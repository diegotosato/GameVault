import { Outlet } from "react-router-dom";
import Header from "../components/Header";
import Footer from "../components/Footer";
import ArrowToTop from "../components/ArrowToTop";

export default function DefaultLayout() {
  return (
    <>
      <Header />
      <ArrowToTop />
      <main>
        <Outlet />
      </main>
      <Footer />
    </>
  );
}
