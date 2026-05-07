<?php
// Fallback redirect to /en/blog
// This file exists for backwards compatibility
// The actual content lives in en/blog.php
header('Location: /en/blog', true, 301);
exit;
?>
