import { createRoot } from "react-dom/client";
import "bootstrap-icons/font/bootstrap-icons.css";

import "./index.css";

// admin css
import "./admin.css";

//import all files from folder /styles
import "./styles/Header.css";
import "./styles/Footer.css";
import "./styles/ArrowToTop.css";
import "./styles/HomePage.css";
import "./styles/Videogames.css";
import "./styles/Login.css";
import "./styles/LandingPage.css";
import "./styles/Profile.css";
import "./styles/FocusVideogame.css";

import App from "./App.jsx";
import axios from "axios";

// impostazioni default chiamate axios
axios.defaults.baseURL = "http://localhost:8000";
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

createRoot(document.getElementById("root")).render(<App />);
