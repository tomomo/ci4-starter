# CI4-STARTER
## 開発環境設定例
### VisualStudioCode
.vscode/settings.json
```
{
  "emmet.triggerExpansionOnTab": true,
  "phpsab.fixerEnable": true,
  "phpsab.snifferEnable": true,
  "phpsab.snifferMode": "onSave",
  "phpsab.standard": "./php-coding-ruleset.xml",
  "phpsab.executablePathCS": "./vendor/squizlabs/php_codesniffer/bin/phpcs",
  "phpsab.executablePathCBF": "./vendor/squizlabs/php_codesniffer/bin/phpcbf",
  "[php]": {
    "editor.formatOnSave": true,
    "editor.defaultFormatter": null
  },
  "[html]": {
    "editor.formatOnSave": true,
    "editor.defaultFormatter": "vscode.html-language-features"
  },
  "html.format.endWithNewline": true
}
```
