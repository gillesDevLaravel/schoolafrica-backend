# Gestion des Pieces

Ce contrôleur gère toutes les opérations CRUD et d’archivage
concernant les pièces (ex: salles, espaces).

## Affiche la liste des pièces avec possibilité de filtrage.

<small class="badge badge-darkred">requires authentication</small>

Filtres disponibles :
- name (recherche partielle)
- etage (exact)
- status (exact)

> Example request:

```bash
curl -X POST \
    "http://localhost/api/piecesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"a","etage":"assumenda","status":"nam"}'

```

```javascript
const url = new URL(
    "http://localhost/api/piecesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "a",
    "etage": "assumenda",
    "status": "nam"
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
    'http://localhost/api/piecesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'a',
            'etage' => 'assumenda',
            'status' => 'nam',
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
<div id="execution-results-POSTapi-piecesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-piecesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-piecesall"></code></pre>
</div>
<div id="execution-error-POSTapi-piecesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-piecesall"></code></pre>
</div>
<form id="form-POSTapi-piecesall" data-method="POST" data-path="api/piecesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-piecesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/piecesall</code></b>
</p>
<p>
<label id="auth-POSTapi-piecesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-piecesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-piecesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>etage</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="etage" data-endpoint="POSTapi-piecesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-piecesall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée une nouvelle pièce.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pieces" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pieces":[{"name":"unde","etage":"quo","description":"at","status":"hic"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/pieces"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pieces": [
        {
            "name": "unde",
            "etage": "quo",
            "description": "at",
            "status": "hic"
        }
    ]
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
    'http://localhost/api/pieces',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pieces' => [
                [
                    'name' => 'unde',
                    'etage' => 'quo',
                    'description' => 'at',
                    'status' => 'hic',
                ],
            ],
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
<div id="execution-results-POSTapi-pieces" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pieces"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pieces"></code></pre>
</div>
<div id="execution-error-POSTapi-pieces" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pieces"></code></pre>
</div>
<form id="form-POSTapi-pieces" data-method="POST" data-path="api/pieces" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pieces', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pieces</code></b>
</p>
<p>
<label id="auth-POSTapi-pieces" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pieces" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>pieces</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>pieces[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="pieces.0.name" data-endpoint="POSTapi-pieces" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pieces[].etage</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="pieces.0.etage" data-endpoint="POSTapi-pieces" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pieces[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pieces.0.description" data-endpoint="POSTapi-pieces" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pieces[].status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="pieces.0.status" data-endpoint="POSTapi-pieces" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Affiche une pièce spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/pieces/vel" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pieces/vel"
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
    'http://localhost/api/pieces/vel',
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
<div id="execution-results-GETapi-pieces--piece-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pieces--piece-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pieces--piece-"></code></pre>
</div>
<div id="execution-error-GETapi-pieces--piece-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pieces--piece-"></code></pre>
</div>
<form id="form-GETapi-pieces--piece-" data-method="GET" data-path="api/pieces/{piece}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pieces--piece-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pieces/{piece}</code></b>
</p>
<p>
<label id="auth-GETapi-pieces--piece-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-pieces--piece-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>piece</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="piece" data-endpoint="GETapi-pieces--piece-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour une pièce existante.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/pieces/est" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"maxime","etage":"cupiditate","description":"repellat","status":"quasi"}'

```

```javascript
const url = new URL(
    "http://localhost/api/pieces/est"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "maxime",
    "etage": "cupiditate",
    "description": "repellat",
    "status": "quasi"
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
    'http://localhost/api/pieces/est',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'maxime',
            'etage' => 'cupiditate',
            'description' => 'repellat',
            'status' => 'quasi',
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
<div id="execution-results-PUTapi-pieces--piece-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-pieces--piece-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-pieces--piece-"></code></pre>
</div>
<div id="execution-error-PUTapi-pieces--piece-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-pieces--piece-"></code></pre>
</div>
<form id="form-PUTapi-pieces--piece-" data-method="PUT" data-path="api/pieces/{piece}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-pieces--piece-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/pieces/{piece}</code></b>
</p>
<p>
<label id="auth-PUTapi-pieces--piece-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-pieces--piece-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>piece</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="piece" data-endpoint="PUTapi-pieces--piece-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-pieces--piece-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>etage</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="etage" data-endpoint="PUTapi-pieces--piece-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-pieces--piece-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-pieces--piece-" data-component="body" required  hidden>
<br>

</p>

</form>


## Met des pièces à la corbeille (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pieces/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[8,5]}'

```

```javascript
const url = new URL(
    "http://localhost/api/pieces/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        8,
        5
    ]
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
    'http://localhost/api/pieces/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                8,
                5,
            ],
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
<div id="execution-results-POSTapi-pieces-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pieces-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pieces-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-pieces-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pieces-trash"></code></pre>
</div>
<form id="form-POSTapi-pieces-trash" data-method="POST" data-path="api/pieces/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pieces-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pieces/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-pieces-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pieces-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-pieces-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-pieces-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure des pièces supprimées (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pieces/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[4,6]}'

```

```javascript
const url = new URL(
    "http://localhost/api/pieces/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        4,
        6
    ]
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
    'http://localhost/api/pieces/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                4,
                6,
            ],
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
<div id="execution-results-POSTapi-pieces-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pieces-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pieces-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-pieces-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pieces-restore"></code></pre>
</div>
<form id="form-POSTapi-pieces-restore" data-method="POST" data-path="api/pieces/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pieces-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pieces/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-pieces-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pieces-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-pieces-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-pieces-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement des pièces (hard delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pieces/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[14,14]}'

```

```javascript
const url = new URL(
    "http://localhost/api/pieces/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        14,
        14
    ]
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
    'http://localhost/api/pieces/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                14,
                14,
            ],
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
<div id="execution-results-POSTapi-pieces-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pieces-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pieces-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-pieces-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pieces-delete"></code></pre>
</div>
<form id="form-POSTapi-pieces-delete" data-method="POST" data-path="api/pieces/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pieces-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pieces/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-pieces-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pieces-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-pieces-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-pieces-delete" data-component="body" hidden>
<br>

</p>

</form>



