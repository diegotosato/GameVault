import { useEffect, useState } from "react";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate } from "react-router-dom";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";
import axios from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";

export default function ForgotPassword() {
  const navigate = useNavigate();

  const { status, setStatus, message, setMessage } = useGlobalContext();

  // loader manager
  const [loader, setLoader] = useState(false);
  // submitted del form
  const [submitted, setSubmitted] = useState(false);

  // valori campi del form forgot pass
  const [email, setEmail] = useState("");

  async function handleForgotPassword(e) {
    e.preventDefault();

    setSubmitted(true);
    if (email.length === 0) return;

    setLoader(true);
    setTimeout(() => setLoader(false), 3000);

    const formData = {
      email: email,
    };

    try {
      await axios.get("/sanctum/csrf-cookie");

      const response = await axios.post("/api/forgot-password", formData);
      console.log(response);

      setStatus(response.status);
      setMessage("Email con link di reset inviato!");
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
          <form id="log-in-form" onSubmit={(e) => handleForgotPassword(e)}>
            <h1 className="log-in-title">Password dimenticata?</h1>

            <hr />

            <p className="forgot-intro">
              Hai dimenticato la password? Nessun problema. Comunicaci il tuo
              indirizzo email e ti invieremo un link per reimpostarla, che ti
              permetterà di sceglierne una nuova.
            </p>

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

            <button type="submit">Invia link di reset password</button>

            <p className="toggle-form" onClick={() => navigate("/log-in")}>
              Torna indietro
            </p>

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
