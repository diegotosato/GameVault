import { useEffect, useState } from "react";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate, useParams, useSearchParams } from "react-router-dom";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";
import axios from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";

export default function ResetPassword() {
  const navigate = useNavigate();

  // estraggo la mail dalla query
  const [searchParams] = useSearchParams();
  const email = searchParams.get("email");

  // token dalla query string
  const params = useParams();
  const token = params.token;

  const { status, setStatus, message, setMessage } = useGlobalContext();

  // loader manager
  const [loader, setLoader] = useState(false);
  // submitted del form
  const [submitted, setSubmitted] = useState(false);

  // valori campi della nuova pass
  const [password, setPassword] = useState("");
  const [confirmPass, setConfirmPass] = useState("");

  async function handleResetPassword(e) {
    e.preventDefault();

    setSubmitted(true);
    if (
      email.length === 0 ||
      password.length === 0 ||
      confirmPass.length === 0 ||
      password !== confirmPass
    )
      return;

    setLoader(true);
    setTimeout(() => setLoader(false), 3000);

    const formData = {
      token: token,
      email: email,
      password: password,
      password_confirmation: confirmPass,
    };

    try {
      await axios.get("/sanctum/csrf-cookie");

      const response = await axios.post("/api/reset-password", formData);

      setStatus(response.status);
      setMessage("Password aggiornata con successo!");
      navigate("/log-in");
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
          <form id="log-in-form" onSubmit={(e) => handleResetPassword(e)}>
            <h1 className="log-in-title">Reset Password</h1>

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
              placeholder={"Email"}
              value={email}
            />

            {submitted && password.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            {submitted && password !== confirmPass && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Password non
                coincidono
              </small>
            )}
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Nuova password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />

            {submitted && confirmPass.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            {submitted && password !== confirmPass && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Password non
                coincidono
              </small>
            )}
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Nuova password"
              value={confirmPass}
              onChange={(e) => setConfirmPass(e.target.value)}
            />

            <button type="submit">Resetta password</button>

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
