# RCONTool
Simple RCON Tool

# Usage
```php
$rcon = new RCONTool();
$rcon->authToServer("0.0.0.0", 19132, "myPassword");
$rcon->sendCommand("say hello there!");
$rcon->close();
```
