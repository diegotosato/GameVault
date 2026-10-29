import { useEffect, useState } from "react";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate } from "react-router-dom";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";
import axios from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";

export default function Login() {
  const navigate = useNavigate();

  const { status, setStatus, message, setMessage, user, setUser } =
    useGlobalContext();

  // loader manager
  const [loader, setLoader] = useState(false);
  // submitted del form
  const [submitted, setSubmitted] = useState(false);

  // valori campi del form log-in
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  async function handleLogin(e) {
    e.preventDefault();

    setSubmitted(true);
    if (email.length === 0 || password.length === 0) return;

    setLoader(true);
    setTimeout(() => setLoader(false), 3000);

    const formData = {
      email: email,
      password: password,
    };

    try {
      await axios.get("/sanctum/csrf-cookie");

      await axios.post("/api/login", formData);

      const { data: userData } = await axios.get("/api/user");
      setUser(userData);
      navigate("/");
    } catch (err) {
      console.log(err);

      if (err.response?.status === 409) {
        navigate("/"); // already authenticated
        return;
      }
      setStatus(err.status);
      setMessage(
        "Qualcosa è andato storto! Ricontrolla le credenziali inserite",
      );
    }
  }

  return (
    <>
      <div className="container-fluid">
        <div className="log-in-logo" onClick={() => navigate("/")}>
          <img src={LogoWhite} alt="GameVault_logo_white" />
        </div>
      </div>

      <div className="log-in-page">
        <section className="log-in-left">
          <form id="log-in-form" onSubmit={(e) => handleLogin(e)}>
            <h1 className="log-in-title">Log In</h1>

            <hr />

            {submitted && email.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            <input
              type="text"
              name="email"
              id="email"
              placeholder="Email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />

            {submitted && password.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />

            <button type="submit">Accedi</button>

            <div className="new-forgot-account">
              <p className="toggle-form" onClick={() => navigate("/register")}>
                Non hai ancora un account?
              </p>

              <p
                className="toggle-form"
                onClick={() => navigate("/forgot-password")}
              >
                Password dimenticata?
              </p>
            </div>

            {status && status >= 400 && status < 500 && (
              <p className="error">{message}</p>
            )}
            {status && status >= 200 && status < 300 && (
              <p className="success">{message}</p>
            )}
          </form>
        </section>

        <section className="log-in-right"></section>

        {loader &&
          createPortal(
            <div className="loader">
              <JellyTriangle size="40" speed="1.0" color="#ff5400" />
            </div>,
            document.body,
          )}
      </div>
    </>
  );
}
