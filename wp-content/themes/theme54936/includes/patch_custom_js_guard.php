<?php
/**
 * Adds array guards to theme54936/includes/custom-js.php around line 157.
 * It detects variables accessed like $var['...'] on that line and ensures
 * each $var is an array before use.
 *
 * Makes a .bak backup alongside the file.
 */
$path = __DIR__ . '/wp-content/themes/theme54936/includes/custom-js.php';
if (!is_file($path)) { exit("File not found: $path\n"); }
$src = file($path); if ($src === false) { exit("Couldn't read file\n"); }

$target = 157;                    // line with the warning
$idx = $target - 1;               // 0-based index
$line = $src[$idx];

// Find variables accessed like $var['...']
if (preg_match_all('/\$([A-Za-z_]\w*)\s*\[/', $line, $m)) {
  $vars = array_unique($m[1]);
  $guards = [];
  foreach ($vars as $v) {
    $guards[] = "if (!is_array(\$$v)) { \$$v = []; }\n";
  }
  // Insert guards a few lines before the target line
  $insertAt = max(0, $idx - 1);
  array_splice($src, $insertAt, 0, $guards);
  // Backup and write
  copy($path, $path . '.bak');
  file_put_contents($path, implode('', $src));
  echo "Patched. Guards added for: " . implode(', ', $vars) . "\n";
  echo "Backup: {$path}.bak\n";
} else {
  echo "No array-like variables found on line $target. Nothing changed.\n";
}
