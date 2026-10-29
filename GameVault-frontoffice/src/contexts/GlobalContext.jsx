import axios from "axios";
import { createContext, useContext, useState, useEffect } from "react";
import { useSearchParams } from "react-router-dom";

const GlobalContext = createContext();

function GlobalProvider({ children }) {
  // user
  const [user, setUser] = useState(null);
  const [isLoadingUser, setIsLoadingUser] = useState(true);

  // messaggi
  const [status, setStatus] = useState(null);
  const [message, setMessage] = useState("");

  // giochi e paginazione
  const [allGames, setAllGames] = useState([]);
  const [pageData, setPageData] = useState(null);
  // giochi filtrabili dalla ricerca
  const [results, setResults] = useState(0);

  //wishlist
  const [wishlist, setWishlist] = useState([]);

  useEffect(() => {
    // fetch utente
    axios
      .get("/api/user")
      .then((res) => {
        if (res.status === 200) setUser(res.data);
      })
      .finally(() => setIsLoadingUser(false));

    // fetch giochi iniziali
    axios.get("/api/videogames").then((res) => {
      setAllGames(res?.data.paginated.data);
      setPageData(res?.data.paginated.links);
    });
  }, []);

  const values = {
    // user
    user,
    setUser,
    isLoadingUser,

    allGames,
    setAllGames,
    pageData,
    setPageData,
    results,
    setResults,

    // messaggi
    status,
    setStatus,
    message,
    setMessage,

    //wishlist
    wishlist,
    setWishlist,
  };

  return (
    <GlobalContext.Provider value={values}>{children}</GlobalContext.Provider>
  );
}

function useGlobalContext() {
  return useContext(GlobalContext);
}

export { GlobalProvider, useGlobalContext };
