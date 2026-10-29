import { useNavigate, useSearchParams } from "react-router-dom";
import { useEffect, useState } from "react";
import axios, { all } from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";

export default function Videogames() {
  const navigate = useNavigate();

  const {
    user,
    allGames,
    setAllGames,
    pageData,
    setPageData,
    results,
    setResults,
    wishlist,
    setWishlist,
  } = useGlobalContext();

  const [consoles, setConsoles] = useState([]);
  const [genres, setGenres] = useState([]);
  const [multiModes, setMultiModes] = useState([]);

  //loader per ricerche
  const [loader, setLoader] = useState(false);

  // pulsante per mostrare altri giochi tramite la paginazione e suo index
  const [showMore, setShowMore] = useState(true);
  const [index, setIndex] = useState(2);

  // fetch iniziale dati filtri
  useEffect(() => {
    axios.get("/sanctum/csrf-cookie");
    axios.get("/api/consoles").then((res) => setConsoles(res?.data));
    axios.get("/api/genres").then((res) => setGenres(res?.data));
    axios.get("/api/multi-modes").then((res) => setMultiModes(res?.data));
    axios.get("/api/videogames").then((res) => setResults(res.data.totalGames));
  }, []);

  // search e filtri
  const [searchParams, setSearchParams] = useSearchParams();
  const [search, setSearch] = useState(searchParams.get("search") || "");

  const initialConsole = searchParams.getAll("console[]") || [];
  const initialGenres = searchParams.getAll("genre[]") || [];
  const initialMulti = searchParams.getAll("multi[]") || [];

  const [checkConsole, setCheckConsole] = useState(initialConsole);
  const [checkGenres, setCheckGenres] = useState(initialGenres);
  const [checkMulti, setCheckMulti] = useState(initialMulti);

  // Sincronizza search con searchParams
  useEffect(() => {
    setSearch(searchParams.get("search") || "");
  }, [searchParams]);

  // I filtri lavorano solo in locale
  function handleConsoleFilters(slug) {
    setCheckConsole((prev) =>
      prev.includes(slug) ? prev.filter((s) => s !== slug) : [...prev, slug],
    );
  }

  function handleGenreFilters(slug) {
    setCheckGenres((prev) =>
      prev.includes(slug) ? prev.filter((s) => s !== slug) : [...prev, slug],
    );
  }

  function handleMultiFilters(slug) {
    setCheckMulti((prev) =>
      prev.includes(slug) ? prev.filter((s) => s !== slug) : [...prev, slug],
    );
  }

  // fetch giochi filtrati
  async function fetchVideogames() {
    try {
      setLoader(true);

      const params = new URLSearchParams();
      if (checkConsole.length > 0)
        checkConsole.forEach((s) => params.append("console[]", s));
      if (checkGenres.length > 0)
        checkGenres.forEach((g) => params.append("genre[]", g));
      if (checkMulti.length > 0)
        checkMulti.forEach((m) => params.append("multi[]", m));

      // searchbar params
      if (search && search.trim() !== "") {
        params.set("search", search.trim());
      }

      // Reset index and allGames for new search
      const page = 1;
      await axios
        .get(`/api/videogames?page=${page}`, { params })
        .then((res) => {
          const games = res.data.paginated.data;
          const results = res.data.totalGames;

          setAllGames(games);
          setResults(results);
          setIndex(2); // next page will be 2
          setShowMore(games.length >= 10);
        });
    } catch (err) {
      console.log(err);
    } finally {
      setLoader(false);
    }
  }

  // mostra altri giochi
  async function handleShowMore() {
    try {
      setLoader(true);

      const params = new URLSearchParams();
      if (checkConsole.length > 0)
        checkConsole.forEach((s) => params.append("console[]", s));
      if (checkGenres.length > 0)
        checkGenres.forEach((g) => params.append("genre[]", g));
      if (checkMulti.length > 0)
        checkMulti.forEach((m) => params.append("multi[]", m));

      await axios
        .get(`/api/videogames?page=${index}`, { params })
        .then((res) => {
          const games = res.data.paginated.data;

          setAllGames((prev) => [...prev, ...games]);
          setIndex((prev) => prev + 1);

          if (games.length < 10) {
            setShowMore(false);
          }
        });
    } catch (err) {
      console.log(err);
    } finally {
      setLoader(false);
    }
  }

  // wishlist
  async function handleWishlist(game) {
    const data = {
      videogame_id: game.id,
    };

    try {
      setLoader(true);
      await axios.get("/sanctum/csrf-cookie");
      // fetch wishlist user iniziali
      await axios.get("/api/user/wishlist").then((res) => {
        const wishlist = res.data.wishlist;
        if (wishlist.some((wish) => wish.videogame_id === game.id)) {
          axios
            .delete("/api/user/wishlist", {
              data: { videogame_id: game.id },
            })
            .then((res) => setWishlist(res.data.wishlist))
            .catch((err) => console.log(err));
        } else {
          axios
            .post("/api/user/wishlist", { videogame_id: game.id })
            .then((res) => setWishlist(res.data.wishlist))
            .catch((err) => console.log(err));
        }
      });
    } catch (err) {
      console.log(err);
    } finally {
      setLoader(false);
    }
  }

  useEffect(() => {
    if (user) {
      axios.get("/sanctum/csrf-cookie").then(() => {
        axios
          .get("/api/user/wishlist")
          .then((res) => setWishlist(res.data.wishlist))
          .catch((err) => console.log(err));
      });
    }
  }, [user]);

  return (
    <>
      <div className="videogames-display">
        <aside id="aside">
          <div className="filters-header">
            <p className="games-count">
              {results > 0 ? results : "0"} risultati
            </p>

            <button
              type="button"
              className="apply-filters"
              onClick={fetchVideogames}
            >
              Applica filtri
            </button>
          </div>

          <input
            type="search"
            name="search"
            id="search"
            placeholder="Cerca videogioco..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
          />

          <div className="filter-category">
            <p className="filter-subtitle">Console</p>

            <div className="genre-selection-grid">
              {consoles?.map((c) => (
                <div className="genre-selection" key={c.slug}>
                  <input
                    type="checkbox"
                    id={`console-${c.slug}`}
                    checked={checkConsole.includes(c.slug)}
                    onChange={() => handleConsoleFilters(c.slug)}
                  />
                  <label htmlFor={`console-${c.slug}`}>{c.name}</label>
                </div>
              ))}
            </div>
          </div>

          <div className="filter-category">
            <p className="filter-subtitle">Generi</p>

            <div className="genre-selection-grid">
              {genres?.map((g) => (
                <div className="genre-selection" key={g.slug}>
                  <input
                    type="checkbox"
                    id={`genre-${g.slug}`}
                    checked={checkGenres.includes(g.slug)}
                    onChange={() => handleGenreFilters(g.slug)}
                  />
                  <label htmlFor={`genre-${g.slug}`}>{g.name}</label>
                </div>
              ))}
            </div>
          </div>

          <div className="filter-category">
            <p className="filter-subtitle">Modalità Multiplayer</p>

            <div className="genre-selection-grid">
              {multiModes?.map((m) => (
                <div className="genre-selection" key={m.slug}>
                  <input
                    type="checkbox"
                    id={`multi-${m.slug}`}
                    checked={checkMulti.includes(m.slug)}
                    onChange={() => handleMultiFilters(m.slug)}
                  />
                  <label htmlFor={`multi-${m.slug}`}>{m.name}</label>
                </div>
              ))}
            </div>
          </div>
        </aside>

        <section className="videogames">
          <div className="section-row">
            {allGames.length > 0 ? (
              allGames?.map((game, i) => (
                <div className="card" key={i}>
                  <div
                    className="card-img"
                    style={{
                      backgroundImage: `url(http://localhost:8000/storage/${game.image})`,
                    }}
                    onClick={() => navigate(`/videogames/${game.slug}`)}
                  ></div>

                  <div className="card-footer">
                    <div className="game-title">{game.name}</div>

                    <div className="game-consoles">
                      {game.consoles.map((console, i) => (
                        <small
                          className="console-badge"
                          key={i}
                          style={{ backgroundColor: console.color }}
                        >
                          {console.name}
                        </small>
                      ))}
                    </div>
                  </div>

                  {user && (
                    <div
                      className="button-wishlist"
                      onClick={(e) => {
                        handleWishlist(game);
                      }}
                    >
                      {wishlist?.some(
                        (wish) => wish.videogame_id === game.id,
                      ) ? (
                        <i className="bi bi-heart-fill"></i>
                      ) : (
                        <i className="bi bi-heart"></i>
                      )}
                    </div>
                  )}
                </div>
              ))
            ) : (
              <p className="no-games">
                <i className="bi bi-emoji-frown-fill"></i>
                Ops! Nessun gioco nella nostra raccolta corrisponde a ciò che
                stai cercando...
              </p>
            )}
          </div>

          {showMore && (
            <button type="button" id="show-more" onClick={handleShowMore}>
              Mostra altri giochi...
            </button>
          )}
        </section>
      </div>

      {loader &&
        createPortal(
          <div className="loader">
            <JellyTriangle size="40" speed="1.0" color="#ff5400" />
          </div>,
          document.body,
        )}
    </>
  );
}
