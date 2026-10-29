import "ldrs/react/JellyTriangle.css";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import DefaultLayout from "./layouts/DefaultLayout";
import HomePage from "./pages/HomePage";
import Videogames from "./pages/Videogames";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Profile from "./pages/Profile";
import LandingPage from "./pages/LandingPage";
import { GlobalProvider } from "./contexts/GlobalContext";
import ForgotPassword from "./pages/ForgotPassword";
import ResetPassword from "./pages/ResetPassword";
import FocusVideogame from "./pages/FocusVideogame";

function App() {
  return (
    <>
      <BrowserRouter>
        <GlobalProvider>
          <Routes>
            <Route element={<DefaultLayout />}>
              <Route path={"/"} element={<HomePage />} />
              <Route path={"/videogames"} element={<Videogames />} />
              <Route path={"/videogames/:slug"} element={<FocusVideogame />} />
            </Route>

            <Route path={"/profile"} element={<Profile />} />
            <Route path={"/landing-page"} element={<LandingPage />} />
            <Route path={"/log-in"} element={<Login />} />
            <Route path={"/forgot-password"} element={<ForgotPassword />} />
            <Route
              path={"/password-reset/:token"}
              element={<ResetPassword />}
            />
            <Route path={"/register"} element={<Register />} />
          </Routes>
        </GlobalProvider>
      </BrowserRouter>
    </>
  );
}

export default App;
