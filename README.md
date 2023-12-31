# tpl_herzpraxis_astroid_ghsvs

Joomla 4 site template with several dependencies(!).

Joomla-4-Site-Template mit zahlreichen Abhängigkeiten(!).

# Be warned!
This is not a template that you install and then it runs smoothly. It needs background knowledge and regular reworking. Versions won't be always backwards compatible. It needs other extensions and stuff to work properly.

# Sei gewarnt!
Das ist kein Template, das man installiert und dann läuft es reibungslos. Es braucht Hintergrundwissen und regelmäßige Nacharbeit. Versionen sind nicht immer rückwärtskompatibel. Es braucht weitere Erweiterungen und Zeugs damit es korrekt läufts.

----------------
# My personal build procedure (WSL 1 or 2, Debian, Win 10)

**Build procedure uses local repo fork of https://github.com/GHSVS-de/buildKramGhsvs**

## Next step: Build package for this repository
- Prepare/adapt `./package.json`.
  - Don't forget: Adapt parameter `versionSub` (is used Bootstrap version).
  - Don't forget: Adapt object `update.versionsSub` (for placeholders like `{{versionsSub.jquery}}` in `joomla.asset.json`.
- `cd /mnt/z/git-kram/tpl_herzpraxis_astroid_ghsvs`

## node/npm updates/installation
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- Version after `_` in filename is version of used Bootstrap (Bundle JS, SCSS).
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

### For Joomla update and changelog server
- Create new release with new tag.
  - See release description in `dist/release.txt`.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Copy/paste and necessary additions.
