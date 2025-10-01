---
name: Security hardening follow-up
about: Track remaining work to fully mitigate log exposure and improve robustness
labels: security, privacy, hardening, priority:high
---

## Summary
Complete follow-up hardening after the initial fix for public log exposure.

## Tasks
- [ ] Move logs outside web root and make path configurable
- [ ] Deny access to /logs for non-Apache servers (Nginx/IIS) or remove dir from web root
- [ ] Add proxy-aware client IP extraction for trusted proxies
- [ ] Add rotation/retention policy and document it
- [ ] Add basic rate limiting for logip.php; optionally check Origin/Referer
- [ ] Remove ips.txt from repo and any servers; consider history rewrite if it contained real data
- [ ] Ensure logs/.htaccess is committed; add Nginx/IIS equivalents
- [ ] Update README: privacy/retention, deployment/server config, remove inaccurate SSL claims
- [ ] Optional: Move inline JS to separate file and add basic CSP

## Acceptance Criteria
- Logs not readable via HTTP in any supported server setup
- Rotation/retention implemented and documented
- Correct client IP recorded in proxy environments (when configured)
- Endpoint resists trivial abuse; logs don’t balloon easily
- Documentation reflects current behavior and policies

## References
- OWASP Logging Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Logging_Cheat_Sheet.html
- GDPR Recital 30: https://gdpr-info.eu/recitals/no-30/
