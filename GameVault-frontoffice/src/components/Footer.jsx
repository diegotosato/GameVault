import { Link } from "react-router-dom";

export default function Footer() {
  const footerData = {
    agency: "GameVault s.r.l.",
    address: "via Classe 149 - Boolean (BL)",
    aboutUs: "Chi siamo",
    workWithUs: "Lavora con noi",
    terms: "Termini e Condizioni",
    privacy: "Privacy Policy",
    cookie: "Cookie Policy",
    join: "Entra nella nostra community",
  };

  const socials = [
    { icon: <i className="bi bi-discord"></i>, color: "#5865F2" },
    { icon: <i className="bi bi-twitter-x"></i>, color: "#1DA1F2" },
    { icon: <i className="bi bi-instagram"></i>, color: "#E4405F" },
    { icon: <i className="bi bi-facebook"></i>, color: "#1877F2" },
    { icon: <i className="bi bi-youtube"></i>, color: "#FF0000" },
    { icon: <i className="bi bi-twitch"></i>, color: "#9146FF" },
  ];

  return (
    <>
      <footer>
        <div className="container">
          <div className="footer-row">
            <div className="footer-col">
              <h3>{footerData.agency}</h3>

              <ul>
                <li>{footerData.address}</li>
                <li>
                  <Link to={"#"}>{footerData.aboutUs}</Link>
                </li>
                <li>
                  <Link to={"#"}>{footerData.workWithUs}</Link>
                </li>
              </ul>
            </div>

            <div className="footer-col">
              <ul>
                <li>
                  <Link to={"#"}>{footerData.terms}</Link>
                </li>
                <li>
                  <Link to={"#"}>{footerData.privacy}</Link>
                </li>
                <li>
                  <Link to={"#"}>{footerData.cookie}</Link>
                </li>
              </ul>
            </div>

            <div className="footer-col">
              <ul>
                <li>{footerData.join}</li>
                <li className="socials">
                  {socials.map((social, index) => (
                    <Link
                      to={"#"}
                      style={{ backgroundColor: `${social.color}` }}
                      key={index}
                      className="social-icon"
                    >
                      {social.icon}
                    </Link>
                  ))}
                </li>
              </ul>
            </div>
          </div>

          <p className="copy">
            Copyright &copy; 2026 GameVault - All rights reserved
          </p>
        </div>
      </footer>
    </>
  );
}
