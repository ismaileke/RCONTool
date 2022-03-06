# RCONTool
Simple RCON Tool

# Usage
```php
$rcon = new RCONTool();
if ($rcon->connectToServer("0.0.0.0", 19132, "myPassword")) {
    $rcon->sendCommand("say hello there!");
    $rcon->sendCommand("tell Test Message from RCON");
    $rcon->close();
}
```
