import { useEffect, useState } from "react";
import LogoWhite from "../assets/img/GameVault-logo-white.png";
import { useNavigate } from "react-router-dom";
import { createPortal } from "react-dom";
import { JellyTriangle } from "ldrs/react";
import axios from "axios";
import { useGlobalContext } from "../contexts/GlobalContext";

export default function Login() {
  const navigate = useNavigate();

  const { user, setUser, isLoadingUser } = useGlobalContext();

  // loader manager
  const [loader, setLoader] = useState(false);
  // submitted del form per email
  const [submitted, setSubmitted] = useState(false);
  // submitted del form per password
  const [submitPass, setSubmitPass] = useState(false);
  // delete account
  const [deleteAccount, setDeleteAccount] = useState(false);
  const [deleteLoader, setDeleteLoader] = useState(false);
  const [deletePassword, setDeletePassword] = useState(false);

  // messaggi indipendenti per i due form
  const [emailStatus, setEmailStatus] = useState(null);
  const [emailMessage, setEmailMessage] = useState("");
  const [passStatus, setPassStatus] = useState(null);
  const [passMessage, setPassMessage] = useState("");

  // cambio email
  const [newEmail, setNewEmail] = useState("");
  const [emailPassword, setEmailPassword] = useState("");

  // cambio password
  const [passCurrentPassword, setPassCurrentPassword] = useState("");
  const [newPassword, setNewPassword] = useState("");
  const [confirmNewPassword, setConfirmNewPassword] = useState("");

  async function handleChangeEmail(e) {
    e.preventDefault();

    setSubmitted(true);
    if (newEmail.length === 0 || emailPassword.length === 0) return;

    setLoader(true);
    setTimeout(() => setLoader(false), 3000);

    try {
      await axios.get("/sanctum/csrf-cookie");

      const response = await axios.post("/api/email/change-request", {
        email: newEmail,
      });

      setEmailStatus(response?.data?.success);
      setEmailMessage(response?.data?.message);
      setNewEmail("");
      setEmailPassword("");
    } catch (err) {
      setEmailStatus(err.response?.status);
      setEmailMessage(err.response?.data?.message || "Errore imprevisto");
    }
  }

  async function handleChangePassword(e) {
    e.preventDefault();

    setSubmitPass(true);
    if (
      passCurrentPassword.length === 0 ||
      newPassword.length === 0 ||
      confirmNewPassword.length === 0 ||
      newPassword !== confirmNewPassword
    )
      return;

    setLoader(true);
    setTimeout(() => setLoader(false), 3000);

    const formData = {
      current_password: passCurrentPassword,
      password: newPassword,
      password_confirmation: confirmNewPassword,
    };

    try {
      await axios.get("/sanctum/csrf-cookie");

      const response = await axios.post("/api/password/update", formData);

      setPassStatus(response?.data?.success);
      setPassMessage(response?.data?.message);
      setPassCurrentPassword("");
      setNewPassword("");
      setConfirmNewPassword("");
    } catch (err) {
      setPassStatus(err.response?.status);
      setPassMessage(err.response?.data?.message || "Errore imprevisto");
    }
  }

  async function handleDelete(e) {
    e.preventDefault();

    setDeleteLoader(true);
    setTimeout(() => setDeleteLoader(false), 3000);

    if (passCurrentPassword.length === 0) return;

    try {
      await axios.get("/sanctum/csrf-cookie");

      await axios.delete("/api/user", {
        data: { password: passCurrentPassword },
      });

      setUser(null);
      navigate("/");
    } catch (err) {
      console.log(err);
    }
  }

  // recupero giochi wishlist utente
  const [userWishes, setUserWishes] = useState([]);

  useEffect(() => {
    axios.get("/sanctum/csrf-cookie");

    axios
      .get("/api/user/wishlist")
      .then((res) => {
        setUserWishes(res.data.wishlist);
      })
      .catch((err) => console.log(err));
  }, []);

  console.log(userWishes);

  // wishlist
  async function handleWishlist(videogame_id) {
    try {
      setLoader(true);

      await axios.get("/sanctum/csrf-cookie");

      // fetch wishlist user iniziali
      await axios
        .delete("/api/user/wishlist", {
          data: { videogame_id: videogame_id },
        })
        .then((res) => {
          setUserWishes(res.data.wishlist);
        });
    } catch (err) {
      console.log(err);
    } finally {
      setLoader(false);
    }
  }

  return (
    <>
      <div className="container-fluid">
        <div className="log-in-logo" onClick={() => navigate("/")}>
          <img src={LogoWhite} alt="GameVault_logo_white" />
        </div>
      </div>

      <div className="profile-page">
        <div className="profile-data">
          <div className="profile-icon">
            <i className="bi bi-person-circle"></i>
          </div>
          <h1 className="profile-name">{user?.name}</h1>
        </div>

        <div className="container">
          <hr />

          <h2 className="security-title">Sicurezza account</h2>

          <div className="account-security">
            <div className="security-left">
              <h3>Cambia la tua email</h3>

              <form onSubmit={(e) => handleChangeEmail(e)}>
                <input
                  type="email"
                  name="email"
                  id="email"
                  value={user?.email}
                />

                {submitted && newEmail.length === 0 && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Campo
                    obbligatorio
                  </small>
                )}
                <input
                  type="email"
                  name="new-email"
                  id="new-email"
                  placeholder="Nuova Email"
                  value={newEmail}
                  onChange={(e) => setNewEmail(e.target.value)}
                />

                {submitted && emailPassword.length === 0 && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Campo
                    obbligatorio
                  </small>
                )}
                <input
                  type="password"
                  name="password"
                  id="email-password"
                  placeholder="Password corrente"
                  value={emailPassword}
                  onChange={(e) => setEmailPassword(e.target.value)}
                />

                <button type="submit">Conferma</button>

                {emailMessage && (
                  <p className={emailStatus === 200 ? "success" : "error"}>
                    {emailMessage}
                  </p>
                )}
              </form>
            </div>

            <div className="security-right">
              <h3>Cambia la tua password</h3>

              <form onSubmit={(e) => handleChangePassword(e)}>
                {submitPass && passCurrentPassword.length === 0 && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Campo
                    obbligatorio
                  </small>
                )}
                <input
                  type="password"
                  name="current-password"
                  id="current-password"
                  placeholder="Password corrente"
                  value={passCurrentPassword}
                  onChange={(e) => setPassCurrentPassword(e.target.value)}
                />

                {submitPass && newPassword.length === 0 && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Campo
                    obbligatorio
                  </small>
                )}
                {submitPass && newPassword !== confirmNewPassword && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Password
                    non coincidono
                  </small>
                )}
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="Nuova password"
                  value={newPassword}
                  onChange={(e) => setNewPassword(e.target.value)}
                />

                {submitPass && confirmNewPassword.length === 0 && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Campo
                    obbligatorio
                  </small>
                )}
                {submitPass && newPassword !== confirmNewPassword && (
                  <small className="error">
                    <i className="bi bi-exclamation-circle-fill"></i> Password
                    non coincidono
                  </small>
                )}
                <input
                  type="password"
                  name="confirm-new-password"
                  id="confirm-new-password"
                  placeholder="Conferma nuova password"
                  value={confirmNewPassword}
                  onChange={(e) => setConfirmNewPassword(e.target.value)}
                />

                <button type="submit">Conferma</button>

                {passMessage && (
                  <p className={passStatus === 200 ? "success" : "error"}>
                    {passMessage}
                  </p>
                )}
              </form>
            </div>
          </div>
        </div>

        <div className="container">
          <h2 className="security-title">La tua lista preferiti</h2>

          <div className="user-wishlist-grid">
            {userWishes?.length > 0
              ? userWishes?.map((wish, i) => (
                  <div className="card" key={i}>
                    <div
                      className="card-img"
                      style={{
                        backgroundImage: `url(http://localhost:8000/storage/${wish.videogame.image})`,
                      }}
                      onClick={() =>
                        navigate(`/videogames/${wish.videogame.slug}`)
                      }
                    ></div>

                    <div className="card-footer">
                      <div className="game-title">{wish.videogame.name}</div>
                    </div>

                    <div
                      className="button-wishlist"
                      onClick={(e) => {
                        handleWishlist(wish.videogame_id);
                      }}
                    >
                      <i className="bi bi-heart-fill"></i>
                    </div>
                  </div>
                ))
              : "Non hai nessuno gioco nella lista dei preferiti al momento"}
          </div>
        </div>

        <div className="profile-delete">
          <button
            type="button"
            className="delete-button"
            onClick={() => setDeleteAccount(true)}
          >
            <i className="bi bi-trash3-fill"></i> Cancella account
          </button>
        </div>
      </div>

      {loader &&
        createPortal(
          <div className="loader">
            <JellyTriangle size="40" speed="1.0" color="#ff5400" />
          </div>,
          document.body,
        )}

      {deleteAccount &&
        createPortal(
          <div className="confirm-delete-message">
            <p>
              <strong>
                Sicuro di voler eliminare definitivamente questo account?
              </strong>
            </p>

            <p>
              <em>
                Questa azione è irreversibile e tutti i tuoi dati verranno
                cancellati in modo permanente
              </em>
            </p>

            <form onSubmit={(e) => handleDelete(e)}>
              Inserisci la password per confermare definitivamente
              <input
                type="password"
                name="password"
                id="password"
                className="input-pass-to-delete"
                value={passCurrentPassword}
                onChange={(e) => setPassCurrentPassword(e.target.value)}
              />{" "}
              <div className="confirm-buttons">
                <button
                  type="button"
                  className="cancel-button"
                  onClick={() => setDeleteAccount(false)}
                >
                  <i className="bi bi-x-circle"></i> Annulla
                </button>

                <button className="delete-button" type="submit">
                  <i className="bi bi-trash3-fill"></i> Conferma cancellazione
                </button>
              </div>
            </form>

            {deleteLoader && (
              <JellyTriangle size="40" speed="1.0" color="#ff5400" />
            )}
          </div>,
          document.body,
        )}
    </>
  );
}
