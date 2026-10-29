import { useNavigate, useLocation } from "react-router-dom";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useGlobalContext } from "../contexts/GlobalContext";
import axios from "axios";
import { useEffect } from "react";

export default function Header() {
  const navigate = useNavigate();
  const location = useLocation();

  const {
    user,
    setUser,
    search,
    setSearch,
    fetchVideogamesBySearch,
    setAllGames,
    setResults,
    setLoader,
  } = useGlobalContext();

  const navLinks = ["PC", "Playstation", "XBOX", "Nintendo"];

  async function handleLogout() {
    try {
      await axios.post("/api/logout");
      setUser(null);
    } catch (err) {
      console.log(err);
    }
  }

  return (
    <header>
      <div className="container-fluid">
        <div className="nav-bar">
          <div className="logo" onClick={() => navigate("/")}>
            <img src={LogoWhite} alt="GameVault_logo_white" />
          </div>

          <div className="user-log-in">
            {user && (
              <button className="log-in" onClick={handleLogout}>
                <i className="bi bi-box-arrow-left"></i> Log Out
              </button>
            )}
            <button
              className="log-in"
              onClick={
                user ? () => navigate("/profile") : () => navigate("/log-in")
              }
            >
              <i className="bi bi-person-circle"></i>{" "}
              {user ? user.name : "Log-In"}
            </button>
          </div>
        </div>
      </div>
    </header>
  );
}
