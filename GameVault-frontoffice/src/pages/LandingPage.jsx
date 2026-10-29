import { useEffect, useState } from "react";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate } from "react-router-dom";

export default function Login() {
  const navigate = useNavigate();

  const [count, setCount] = useState(5);

  useEffect(() => {
    const interval = setInterval(() => {
      setCount((prev) => prev - 1);
    }, 1000);

    return () => clearInterval(interval);
  }, [count]);

  useEffect(() => {
    if (count === 0) {
      navigate("/profile");
    }
  }, [count]);

  return (
    <>
      <div className="container-fluid">
        <div className="log-in-logo" onClick={() => navigate("/")}>
          <img src={LogoWhite} alt="GameVault_logo_white" />
        </div>
      </div>

      <div className="landing-page">
        <div className="landing-response">
          <i className="bi bi-check-circle"></i>
          <p className="landing-name">Email cambiata con successo</p>

          <p className="landing-redirect">
            Sarai reindirizzato alla pagina del profilo tra ...{count}
          </p>
        </div>
      </div>
    </>
  );
}
