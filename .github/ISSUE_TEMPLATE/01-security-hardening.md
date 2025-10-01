---
name: Security hardening follow-up
about: Finish mitigation of log exposure and improve operational security
title: "Hardening: finalize mitigation for log exposure"
labels: ["security", "privacy", "hardening", "priority:high"]
assignees: []
---

## Summary
Follow-up on the fix that moved logging to `logs/ips.ndjson` and enforced POST + server-derived IP. Complete the remaining steps to ensure logs are never web-accessible and operational posture is sound.

## Tasks
- [ ] Storage: move logs outside web root (configurable path); ensure perms 0750 dir, 0640 file
- [ ] Server config: deny `/logs` (Nginx/IIS equivalents) or remove directory from web root
- [ ] Proxy awareness: trusted proxies + X-Forwarded-For parsing with validation
- [ ] Rotation/retention: add rotation (daily/size) and retention policy; document
- [ ] Abuse controls: basic rate limiting; optional Origin/Referer checks
- [ ] Repo hygiene: remove `ips.txt` from repo/server; consider history rewrite
- [ ] Docs: update README (privacy/retention, deployment guidance); remove inaccurate claims
- [ ] Optional: move inline JS to file, add basic CSP

## Acceptance Criteria
- Logs cannot be fetched over HTTP in any supported setup
- Logs rotate and adhere to retention policy
- Correct client IP captured when behind configured proxies
- Endpoint resilient to trivial flooding
- README updated accordingly

## References
- OWASP Logging Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Logging_Cheat_Sheet.html
- GDPR Recital 30: https://gdpr-info.eu/recitals/no-30/
