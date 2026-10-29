import { Link, useParams } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";

export default function FocusVideogame() {
  const navigate = useNavigate();

  const { user } = useGlobalContext();

  const { slug } = useParams();

  const [loader, setLoader] = useState(false);
  const [game, setGame] = useState(null);

  //reviews
  const [gameReviews, setGameReviews] = useState(null);
  const [reviewsPages, setReviewsPages] = useState(null);
  const [reviewsLoader, setReviewsLoader] = useState(false);
  const [showMoreReviews, setShowMoreReviews] = useState(true);
  const [index, setIndex] = useState(2);

  //raccolgo info per mandare review
  const [submitted, setSubmitted] = useState(false);
  const [reviewText, setReviewText] = useState("");
  const [success, setSuccess] = useState(null);

  async function handleSendReview() {
    setSubmitted(true);
    if (reviewText.length === 0) return;

    const reviewData = {
      review_text: reviewText,
      videogame_id: game.id,
      user_id: user.id,
      user_name: user.name,
    };

    try {
      setLoader(true);

      await axios.get("/sanctum/csrf-cookie");
      await axios.post("/api/new-user-review", reviewData).then((res) => {
        if (res.status >= 200 && res.status < 300) {
          return setSuccess(true);
        }
      });
    } catch (err) {
      console.log(err);
    } finally {
      setLoader(false);
    }
  }

  useEffect(() => {
    axios.get(`/api/videogames/${slug}`).then((res) => {
      // return console.log(res.data.reviews.data);

      setGame(res.data.game);
      setGameReviews(res.data.reviews.data);
      setReviewsPages(res.data.reviews.links);
    });
  }, []);

  async function handleShowMoreReviews() {
    try {
      setReviewsLoader(true);

      await axios
        .get(
          `http://localhost:8000/api/videogames/grand-theft-auto-v?page=${index}`,
        )
        .then((res) => {
          const response = res.data.reviews;
          setGameReviews((prev) => [...prev, ...response.data]);
          setIndex((prev) => prev + 1);

          if (response.data.length < 10) {
            setShowMoreReviews(false);
          }
        });
    } catch (err) {
      console.log(err);
    } finally {
      setReviewsLoader(false);
    }
  }

  return (
    <>
      <div
        className="focus-jumbotron"
        style={{
          backgroundImage: `url(http://localhost:8000/storage/${game?.image})`,
        }}
      >
        <div className="focus-tabs">
          <div
            className="left-tab"
            style={{
              backgroundImage: `url(http://localhost:8000/storage/${game?.image})`,
            }}
          ></div>

          <div className="right-tab">
            <h1 className="game-title">{game?.name}</h1>
            <p className="game-dev">
              <em>{game?.developer?.name}</em>
            </p>
            <div className="focus-game-consoles">
              {game?.consoles?.map((console, index) => (
                <small
                  className="console-badge"
                  key={index}
                  style={{
                    backgroundColor: `${console.color}`,
                  }}
                >
                  {console.name}
                </small>
              ))}
            </div>

            <p className="game-about">Riguardo al gioco</p>
            <p className="game-about-text">{game?.description}</p>
          </div>
        </div>
      </div>

      <section className="game-genres">
        <div className="container">
          <h2 className="game-subtitle">Generi</h2>

          <div className="info-badges">
            {game?.genres?.map((genre, index) => (
              <div className="info-badge" key={index}>
                {genre.name}
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="game-multi-modes">
        <div className="container">
          <h2 className="game-subtitle">Modalità Multiplayer</h2>

          <div className="info-badges">
            {game?.multiplayer_modes?.map((mm, index) => (
              <div className="info-badge" key={index}>
                {mm.name}
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="game-reviews">
        <div className="container">
          <h2 className="game-subtitle">Recensioni</h2>

          <div className="reviews-grid">
            {gameReviews?.map((review, index) => {
              const formatted = new Date(review.created_at).toLocaleDateString(
                "it-IT",
                {
                  day: "numeric",
                  month: "long",
                  year: "numeric",
                },
              );

              return (
                <div className="review-card" key={index}>
                  <div className="review-user">
                    <i className="bi bi-person-circle"></i>
                    {review.user_name}
                  </div>

                  <div className="review-text">{review.content}</div>

                  <div className="review-separator"></div>

                  <div className="review-date">{formatted}</div>
                </div>
              );
            })}
          </div>

          {reviewsLoader && (
            <div className="reviews-loader">
              <JellyTriangle size="40" speed="1.0" color="#ff5400" />
            </div>
          )}

          {showMoreReviews && (
            <button
              type="button"
              className="load-reviews"
              onClick={handleShowMoreReviews}
            >
              Vedi altre recensioni
            </button>
          )}
        </div>

        {user && (
          <div className="container">
            <div className="user-review">
              <button className="user-name-review">
                <i className="bi bi-person-circle"></i> {user?.name}
              </button>

              <h4>Scrivi la tua recensione!</h4>
              <p className="recommend">
                Questa sezione ti permette di recensire il gioco per dare un
                valido contributo agli altri utenti per indirizzare la loro
                scelta all'acquisto o meno. Sei libero di scrivere tutto quello
                che ti è piaciuto o quello che ti ha deluso.
              </p>

              <p className="attention">
                Per favore evita di parlare in questa sezione dei prezzi del
                gioco o delle recensioni altrui. Lasciaci la tua opinione!
              </p>

              <textarea
                className="new-review-text"
                style={{ resize: "none" }}
                rows={5}
                value={reviewText}
                onChange={(e) => setReviewText(e.target.value)}
              ></textarea>

              {submitted && reviewText.length === 0 && (
                <div className="empty-review">
                  <i className="bi bi-exclamation-circle-fill"></i> Non puoi
                  lasciare una recensione senza testo
                </div>
              )}

              {success && (
                <div className="success-review">
                  Recensione lasciata con successo! Aggiorna la pagina per
                  vederla assieme a quelle degli altri utenti!
                </div>
              )}

              <button
                type="button"
                className="send-review"
                onClick={handleSendReview}
              >
                Invia recensione
              </button>
            </div>
          </div>
        )}

        {loader &&
          createPortal(
            <div className="loader">
              <JellyTriangle size="40" speed="1.0" color="#ff5400" />
            </div>,
            document.body,
          )}
      </section>
    </>
  );
}
