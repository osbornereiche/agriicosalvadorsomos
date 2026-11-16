:root {
  --sv: #8a001b;
  --bg: #0f141b;
  --panel: #171e28;
  --line: #2a3442;
  --text: #e8eef7;
  --muted: #9aa8ba;
  --ok: #22c55e;
  --fail: #ef4444;
  --font: "Nunito Sans", "Segoe UI", sans-serif;
}

* { box-sizing: border-box; }
body.monitor-page {
  margin: 0;
  min-height: 100vh;
  background: var(--bg);
  color: var(--text);
  font-family: var(--font);
}

.monitor-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  padding: 18px 22px;
  border-bottom: 1px solid var(--line);
  background: #121821;
}

.monitor-title h1 {
  margin: 0;
  font-size: 22px;
}

.monitor-title p {
  margin: 4px 0 0;
  color: var(--muted);
  font-size: 13px;
}

.monitor-right {
  display: flex;
  align-items: center;
  gap: 14px;
}

.monitor-user { color: var(--muted); font-size: 13px; }

.monitor-live {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 700;
}

.live-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--ok);
  box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
  animation: pulse 1.4s infinite;
}

@keyframes pulse {
  0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.55); }
  70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
  100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

.monitor-logout {
  color: #fff;
  text-decoration: none;
  background: var(--sv);
  padding: 8px 14px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 700;
}

.monitor-stats {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 12px;
  padding: 16px 22px;
}

.stat-card {
  background: var(--panel);
  border: 1px solid var(--line);
  border-radius: 14px;
  padding: 14px 16px;
}

.stat-card span {
  display: block;
  color: var(--muted);
  font-size: 12px;
  margin-bottom: 6px;
}

.stat-card strong {
  font-size: 28px;
}

.stat-card.ok strong { color: var(--ok); }
.stat-card.fail strong { color: var(--fail); }

.monitor-toolbar {
  display: flex;
  gap: 12px;
  align-items: center;
  padding: 0 22px 12px;
  color: var(--muted);
  font-size: 13px;
}

.monitor-toolbar button {
  background: #222b38;
  color: var(--text);
  border: 1px solid var(--line);
  border-radius: 999px;
  padding: 8px 12px;
  cursor: pointer;
}

.monitor-board-wrap {
  padding: 0 22px 22px;
}

.monitor-board {
  background: var(--panel);
  border: 1px solid var(--line);
  border-radius: 14px;
  overflow: auto;
  max-height: calc(100vh - 260px);
}

.monitor-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  min-width: 1100px;
}

.monitor-table th,
.monitor-table td {
  padding: 10px 12px;
  border-bottom: 1px solid var(--line);
  text-align: left;
  font-size: 13px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 180px;
}

.monitor-table td:nth-child(5),
.monitor-table td:nth-child(6) {
  max-width: 220px;
  font-weight: 700;
  color: #fff;
}

.monitor-table th {
  position: sticky;
  top: 0;
  background: #1b2430;
  color: var(--muted);
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  z-index: 1;
}

.monitor-table tr.is-new td {
  filter: brightness(1.12);
}

/* Colores por ingreso: 1 azul, 2 verde, 3 rojo, 4 gris, 5 amarillo, y se repite */
.monitor-table tr.row-azul td {
  background: rgba(37, 99, 235, 0.28);
  border-left: 4px solid #2563eb;
}
.monitor-table tr.row-verde td {
  background: rgba(34, 197, 94, 0.25);
  border-left: 4px solid #22c55e;
}
.monitor-table tr.row-rojo td {
  background: rgba(239, 68, 68, 0.25);
  border-left: 4px solid #ef4444;
}
.monitor-table tr.row-gris td {
  background: rgba(148, 163, 184, 0.22);
  border-left: 4px solid #94a3b8;
}
.monitor-table tr.row-amarillo td {
  background: rgba(234, 179, 8, 0.28);
  border-left: 4px solid #eab308;
  color: #fff8d6;
}

.badge-color {
  display: inline-flex;
  min-width: 24px;
  justify-content: center;
  padding: 2px 8px;
  border-radius: 999px;
  background: rgba(0, 0, 0, 0.25);
  font-size: 12px;
  font-weight: 800;
}

.badge-estado {
  display: inline-flex;
  padding: 3px 8px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 800;
}

.badge-pendiente {
  background: rgba(37, 99, 235, 0.25);
  color: #bfdbfe;
}

.badge-rechazado {
  background: rgba(239, 68, 68, 0.3);
  color: #fecaca;
}

.col-actions {
  white-space: nowrap;
  overflow: visible !important;
  text-overflow: unset !important;
  max-width: none !important;
}

.btn-act {
  border: 0;
  border-radius: 8px;
  padding: 6px 8px;
  margin-right: 4px;
  font-size: 11px;
  font-weight: 800;
  cursor: pointer;
}

.btn-copy {
  background: #334155;
  color: #fff;
}

.btn-error {
  background: #dc2626;
  color: #fff;
}

.btn-del {
  background: #64748b;
  color: #fff;
}

.btn-act:hover {
  filter: brightness(1.08);
}

.cell-copy {
  position: relative;
  padding-right: 34px !important;
  overflow: visible !important;
}

.cell-copy .cell-value {
  display: inline-block;
  max-width: calc(100% - 28px);
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: middle;
}

.btn-copy-one {
  position: absolute;
  right: 6px;
  top: 50%;
  transform: translateY(-50%);
  width: 24px;
  height: 24px;
  border: 0;
  border-radius: 6px;
  background: rgba(15, 23, 42, 0.55);
  color: #fff;
  font-size: 12px;
  font-weight: 800;
  cursor: pointer;
  line-height: 1;
  padding: 0;
}

.btn-copy-one:hover,
.btn-copy-one.is-copied {
  background: #2563eb;
}

.monitor-table .empty-row td {
  text-align: center;
  color: var(--muted);
  padding: 28px;
}

.badge-paso {
  display: inline-flex;
  padding: 2px 8px;
  border-radius: 999px;
  background: #243041;
  color: #d7e2f2;
  font-size: 11px;
  font-weight: 700;
}

@media (max-width: 900px) {
  .monitor-stats {
    grid-template-columns: 1fr;
    padding: 12px 14px;
  }

  .monitor-header {
    flex-direction: column;
    align-items: flex-start;
    padding: 14px 16px;
  }

  .monitor-right {
    flex-wrap: wrap;
    width: 100%;
  }

  .monitor-toolbar {
    padding: 10px 14px;
    flex-wrap: wrap;
    gap: 10px;
  }

  .monitor-board-wrap {
    padding: 0 10px 20px;
  }

  .monitor-board {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .monitor-table {
    min-width: 980px;
  }

  .monitor-table th,
  .monitor-table td {
    font-size: 12px;
    padding: 8px 8px;
  }

  .row-actions {
    flex-wrap: wrap;
  }
}

@media (max-width: 480px) {
  .monitor-title h1 {
    font-size: 18px;
  }

  .monitor-title p {
    font-size: 12px;
  }

  .stat-card strong {
    font-size: 22px;
  }
}
