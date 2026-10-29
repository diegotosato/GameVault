import { useEffect, useState } from "react";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate } from "react-router-dom";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";
import axios from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";

export default function Login() {
  const navigate = useNavigate();

  const { status, setStatus, message, setMessage } = useGlobalContext();

  // loader manager
  const [loader, setLoader] = useState(false);

  // submitted del form
  const [submitted, setSubmitted] = useState(false);

  // valori campi del form log-in
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  // valori campi del form register
  const [name, setName] = useState("");
  const [lastname, setLastname] = useState("");
  const [confirmPass, setConfirmPass] = useState("");

  async function handleRegister(e) {
    e.preventDefault();

    setSubmitted(true);
    if (
      name.length === 0 ||
      email.length === 0 ||
      password.length === 0 ||
      confirmPass.length === 0 ||
      password !== confirmPass
    )
      return;

    setLoader(true);
    setTimeout(() => setLoader(false), 3000);

    const formData = {
      name: name.concat(" ", lastname),
      email: email,
      password: password,
      password_confirmation: confirmPass,
    };

    // return console.log(formData);

    try {
      await axios.get("/sanctum/csrf-cookie");

      const response = await axios.post("/api/register", formData);

      setStatus(response.status);
      setMessage("Registrazione avvenuta con successo!");
      navigate("/log-in");
    } catch (err) {
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
          <form id="log-in-form" onSubmit={(e) => handleRegister(e)}>
            <h1 className="log-in-title">Registrati</h1>

            <hr />

            {submitted && name.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            <input
              type="text"
              name="name"
              id="name"
              placeholder="Nome"
              value={name}
              onChange={(e) => setName(e.target.value)}
            />

            {submitted && lastname.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            <input
              type="text"
              name="lastname"
              id="lastname"
              placeholder="Cognome"
              value={lastname}
              onChange={(e) => setLastname(e.target.value)}
            />

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
            {password !== confirmPass && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Password non
                combaciano
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

            {submitted && confirmPass.length === 0 && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Campo
                obbligatorio
              </small>
            )}
            {password !== confirmPass && (
              <small className="error">
                <i className="bi bi-exclamation-circle-fill"></i> Password non
                combaciano
              </small>
            )}
            <input
              type="password"
              name="password_confirmation"
              id="password_confirmation"
              placeholder="Conferma password"
              value={confirmPass}
              onChange={(e) => setConfirmPass(e.target.value)}
            />

            <button type="submit">Registrati</button>

            <p className="toggle-form" onClick={() => navigate("/log-in")}>
              Torna indietro
            </p>

            {status && status >= 400 && status < 500 && (
              <p className="error">{message}</p>
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
