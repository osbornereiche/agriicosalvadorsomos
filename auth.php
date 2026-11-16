/* Compartido: cookies, legales, pie */
.site-footer {
  position: relative;
  z-index: 5;
  padding: 18px 20px 28px;
  text-align: center;
  font-size: 12px;
  color: #5b6470;
}

.site-footer a {
  color: #920027;
  font-weight: 700;
  text-decoration: none;
  margin: 0 6px;
}

.site-footer a:hover {
  text-decoration: underline;
}

.cookie-banner {
  position: fixed;
  left: 16px;
  right: 16px;
  bottom: 16px;
  z-index: 1200;
  max-width: 720px;
  margin: 0 auto;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 16px 40px rgba(20, 30, 50, 0.2);
  padding: 16px 18px;
  display: none;
  align-items: flex-start;
  gap: 14px;
}

.cookie-banner.is-visible {
  display: flex;
}

.cookie-banner p {
  margin: 0;
  font-size: 13px;
  line-height: 1.45;
  color: #333;
  flex: 1;
}

.cookie-banner a {
  color: #920027;
  font-weight: 700;
}

.cookie-actions {
  display: flex;
  gap: 8px;
  flex-shrink: 0;
}

.cookie-actions button {
  border: 0;
  border-radius: 999px;
  padding: 10px 14px;
  font-size: 13px;
  font-weight: 800;
  cursor: pointer;
}

.cookie-accept {
  background: #920027;
  color: #fff;
}

.cookie-reject {
  background: #eef1f5;
  color: #333;
}

@media (max-width: 640px) {
  .cookie-banner {
    flex-direction: column;
    bottom: 12px;
    left: 12px;
    right: 12px;
  }

  .cookie-actions {
    width: 100%;
  }

  .cookie-actions button {
    flex: 1;
  }
}

/* Páginas legales */
.legal-page {
  min-height: 100vh;
  background: linear-gradient(160deg, #f7eef1, #f5f7fb);
  font-family: "Nunito Sans", "Segoe UI", sans-serif;
  color: #222;
}

.legal-wrap {
  max-width: 820px;
  margin: 0 auto;
  padding: 28px 20px 60px;
}

.legal-card {
  background: #fff;
  border-radius: 18px;
  padding: 28px 24px;
  box-shadow: 0 16px 40px rgba(20, 30, 50, 0.1);
}

.legal-card img {
  height: 26px;
  margin-bottom: 18px;
}

.legal-card h1 {
  margin: 0 0 8px;
  font-size: clamp(24px, 4vw, 32px);
  color: #920027;
}

.legal-card .meta {
  color: #777;
  font-size: 13px;
  margin-bottom: 22px;
}

.legal-card h2 {
  margin: 22px 0 8px;
  font-size: 18px;
  color: #1a1a1a;
}

.legal-card p,
.legal-card li {
  font-size: 15px;
  line-height: 1.55;
  color: #444;
}

.legal-card ul {
  padding-left: 18px;
}

.legal-back {
  display: inline-flex;
  margin-bottom: 14px;
  color: #920027;
  font-weight: 700;
  text-decoration: none;
}
