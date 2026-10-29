import { Link } from "react-router-dom";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate } from "react-router-dom";
import tryImg from "../assets/img/jumbotron.jpg";
import { useGlobalContext } from "../contexts/GlobalContext";
import { useEffect, useState } from "react";
import axios from "axios";

export default function HomePage() {
  const navigate = useNavigate();

  const [allGames, setAllGames] = useState([]);

  useEffect(() => {
    axios.get("/api/videogames").then((res) => {
      setAllGames(res?.data.paginated.data);
    });
  }, []);

  return (
    <>
      <div className="jumbotron">
        <h1 className="slogan">
          La tua guida nel mondo dei videogiochi multiplayer
        </h1>
      </div>

      <section className="explore">
        <div className="container">
          <span className="subtitle" onClick={() => navigate("/videogames")}>
            Esplora giochi <i className="bi bi-arrow-right-short"></i>
          </span>

          <div className="section-row">
            {allGames?.map((game, index) => {
              if (index <= 5) {
                return (
                  <div className="card" key={index}>
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
                        {game.consoles.map((console, index) => (
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
                    </div>
                  </div>
                );
              }
            })}
          </div>
        </div>
      </section>
    </>
  );
}
