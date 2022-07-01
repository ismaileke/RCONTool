# RCONTool
Simple RCON Tool

# Usage
```php
$rcon = new RCONTool();
if ($rcon->connectToServer("0.0.0.0", 19132, "myPassword")) {
    echo "Response Data: " . $rcon->sendCommand("list");
    echo "Response Data: " . $rcon->sendCommand("tell Test Message from RCON");
    $rcon->close();
}
```
