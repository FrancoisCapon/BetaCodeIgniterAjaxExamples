# CodeIgniter Ajax Examples

### `Routes.php`

```php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/ajax-examples', 'AjaxExamples::index');
$routes->get('/ajax-examples/compute-double/(-?[0-9]+)', 'AjaxExamples::computeDouble/$1');
$routes->post('/ajax-examples/compute-uppercase', 'AjaxExamples::computeUppercase');

```

### Others `files`

Place them in their respective folders:
| What | File | Where |
| :--- | :--- |  :--- |
| The controller | `AjaxExamples.php` |`\app\Controllers\`|
| The "page" | `ajax_examples.php` | `\app\Controllers\Views\` |
| The fixed toobarloader | `toolbarloader.js` | `\vendor\codeigniter4\framework\system\Debug\Toolbar\Views\` |

