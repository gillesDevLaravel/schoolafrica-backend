# Memos

Ce contrôleur gère toutes les opérations CRUD et d'archivage
concernant les mémos.

## Lister les mémos avec possibilité de filtrage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/memosall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"Information","date":"2026-03-12","date_start":"2026-03-01","date_end":"2026-03-31","filter_value":"important","pageItems":1,"nbreItems":20,"name":"Conseil"}'

```

```javascript
const url = new URL(
    "http://localhost/api/memosall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "Information",
    "date": "2026-03-12",
    "date_start": "2026-03-01",
    "date_end": "2026-03-31",
    "filter_value": "important",
    "pageItems": 1,
    "nbreItems": 20,
    "name": "Conseil"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/memosall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type' => 'Information',
            'date' => '2026-03-12',
            'date_start' => '2026-03-01',
            'date_end' => '2026-03-31',
            'filter_value' => 'important',
            'pageItems' => 1,
            'nbreItems' => 20,
            'name' => 'Conseil',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-memosall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-memosall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-memosall"></code></pre>
</div>
<div id="execution-error-POSTapi-memosall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-memosall"></code></pre>
</div>
<form id="form-POSTapi-memosall" data-method="POST" data-path="api/memosall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-memosall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/memosall</code></b>
</p>
<p>
<label id="auth-POSTapi-memosall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-memosall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Filtre par type.
</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Filtre par date.
</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Filtre à partir de cette date.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Filtre jusqu'à cette date.
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Recherche globale.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Numéro de page.
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Nombre d'éléments par page.
</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-memosall" data-component="body"  hidden>
<br>
Filtre par nom.
</p>

</form>


## Créer un ou plusieurs mémos.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/memos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"memos":"dolorem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/memos"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "memos": "dolorem"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/memos',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'memos' => 'dolorem',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-memos" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-memos"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-memos"></code></pre>
</div>
<div id="execution-error-POSTapi-memos" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-memos"></code></pre>
</div>
<form id="form-POSTapi-memos" data-method="POST" data-path="api/memos" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-memos', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/memos</code></b>
</p>
<p>
<label id="auth-POSTapi-memos" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-memos" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>memos</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des mémos à créer.
</summary>
<br>
<p>
<b><code>memos[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="memos.0.name" data-endpoint="POSTapi-memos" data-component="body" required  hidden>
<br>
Nom du mémo.
</p>
<p>
<b><code>memos[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="memos.0.description" data-endpoint="POSTapi-memos" data-component="body" required  hidden>
<br>
Description du mémo.
</p>
<p>
<b><code>memos[].type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="memos.0.type" data-endpoint="POSTapi-memos" data-component="body"  hidden>
<br>
Type du mémo.
</p>
<p>
<b><code>memos[].date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="memos.0.date" data-endpoint="POSTapi-memos" data-component="body"  hidden>
<br>
Date du mémo.
</p>
<p>
<b><code>memos[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="memos.0.image" data-endpoint="POSTapi-memos" data-component="body"  hidden>
<br>
URL de l'image.
</p>
</details>
</p>

</form>


## Afficher un mémo spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/memos/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/memos/12"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/memos/12',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-GETapi-memos--memo-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-memos--memo-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-memos--memo-"></code></pre>
</div>
<div id="execution-error-GETapi-memos--memo-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-memos--memo-"></code></pre>
</div>
<form id="form-GETapi-memos--memo-" data-method="GET" data-path="api/memos/{memo}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-memos--memo-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/memos/{memo}</code></b>
</p>
<p>
<label id="auth-GETapi-memos--memo-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-memos--memo-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>memo</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="memo" data-endpoint="GETapi-memos--memo-" data-component="url" required  hidden>
<br>
ID du mémo.
</p>
</form>


## Mettre à jour un mémo.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/memos/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Conseil d'Administration","description":"Informations importantes","type":"Information","date":"2026-03-12","image":"https:\/\/example.com\/image.jpg"}'

```

```javascript
const url = new URL(
    "http://localhost/api/memos/12"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Conseil d'Administration",
    "description": "Informations importantes",
    "type": "Information",
    "date": "2026-03-12",
    "image": "https:\/\/example.com\/image.jpg"
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/memos/12',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'Conseil d\'Administration',
            'description' => 'Informations importantes',
            'type' => 'Information',
            'date' => '2026-03-12',
            'image' => 'https://example.com/image.jpg',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-PUTapi-memos--memo-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-memos--memo-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-memos--memo-"></code></pre>
</div>
<div id="execution-error-PUTapi-memos--memo-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-memos--memo-"></code></pre>
</div>
<form id="form-PUTapi-memos--memo-" data-method="PUT" data-path="api/memos/{memo}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-memos--memo-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/memos/{memo}</code></b>
</p>
<p>
<label id="auth-PUTapi-memos--memo-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-memos--memo-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>memo</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="memo" data-endpoint="PUTapi-memos--memo-" data-component="url" required  hidden>
<br>
ID du mémo.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-memos--memo-" data-component="body"  hidden>
<br>
Nom du mémo.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-memos--memo-" data-component="body"  hidden>
<br>
Description du mémo.
</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-memos--memo-" data-component="body"  hidden>
<br>
Type du mémo.
</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-memos--memo-" data-component="body"  hidden>
<br>
Date du mémo.
</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="PUTapi-memos--memo-" data-component="body"  hidden>
<br>
URL de l'image.
</p>

</form>


## Archiver des mémos.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/memos/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/memos/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "[1,2,3]"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/memos/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => '[1,2,3]',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-memos-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-memos-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-memos-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-memos-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-memos-trash"></code></pre>
</div>
<form id="form-POSTapi-memos-trash" data-method="POST" data-path="api/memos/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-memos-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/memos/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-memos-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-memos-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à archiver.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-memos-trash" data-component="body" required  hidden>
<br>
ID d'un mémo existant.
</p>
</details>
</p>

</form>


## Restaurer des mémos archivés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/memos/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/memos/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "[1,2,3]"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/memos/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => '[1,2,3]',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-memos-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-memos-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-memos-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-memos-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-memos-restore"></code></pre>
</div>
<form id="form-POSTapi-memos-restore" data-method="POST" data-path="api/memos/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-memos-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/memos/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-memos-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-memos-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à restaurer.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-memos-restore" data-component="body" required  hidden>
<br>
ID d'un mémo existant.
</p>
</details>
</p>

</form>


## Supprimer définitivement des mémos.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/memos/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/memos/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "[1,2,3]"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/memos/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => '[1,2,3]',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-memos-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-memos-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-memos-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-memos-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-memos-delete"></code></pre>
</div>
<form id="form-POSTapi-memos-delete" data-method="POST" data-path="api/memos/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-memos-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/memos/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-memos-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-memos-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à supprimer.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-memos-delete" data-component="body" required  hidden>
<br>
ID d'un mémo existant.
</p>
</details>
</p>

</form>



