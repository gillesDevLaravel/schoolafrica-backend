# Gestion Retard Scolaire | School Delay

Ce contrôleur gère toutes les opérations CRUD et d’archivage
concernant le Retard Scolaire.

## Récupère la liste paginée des retards scolaires.

<small class="badge badge-darkred">requires authentication</small>

Permet de filtrer par idStudent, idCourse, date, hour.
La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).

> Example request:

```bash
curl -X POST \
    "http://localhost/api/school-delaysall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"dolor","nbreItems":1,"pageItems":14,"idClasse":2,"idStudent":7,"idCourse":4,"date":"2025-11-22T14:46:54+0000","hour":"14:46"}'

```

```javascript
const url = new URL(
    "http://localhost/api/school-delaysall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "dolor",
    "nbreItems": 1,
    "pageItems": 14,
    "idClasse": 2,
    "idStudent": 7,
    "idCourse": 4,
    "date": "2025-11-22T14:46:54+0000",
    "hour": "14:46"
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
    'http://localhost/api/school-delaysall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'filter_value' => 'dolor',
            'nbreItems' => 1,
            'pageItems' => 14,
            'idClasse' => 2,
            'idStudent' => 7,
            'idCourse' => 4,
            'date' => '2025-11-22T14:46:54+0000',
            'hour' => '14:46',
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
<div id="execution-results-POSTapi-school-delaysall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-school-delaysall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-school-delaysall"></code></pre>
</div>
<div id="execution-error-POSTapi-school-delaysall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-school-delaysall"></code></pre>
</div>
<form id="form-POSTapi-school-delaysall" data-method="POST" data-path="api/school-delaysall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-school-delaysall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/school-delaysall</code></b>
</p>
<p>
<label id="auth-POSTapi-school-delaysall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-school-delaysall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idCourse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idCourse" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>hour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="hour" data-endpoint="POSTapi-school-delaysall" data-component="body"  hidden>
<br>
The value must be a valid date in the format H:i.
</p>

</form>


## Crée un nouveau retard scolaire.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/school-delays" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"hour":"14:46","date":"2025-11-22T14:46:54+0000","description":"sed","idStudents":[20,4],"idCourse":19}'

```

```javascript
const url = new URL(
    "http://localhost/api/school-delays"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "hour": "14:46",
    "date": "2025-11-22T14:46:54+0000",
    "description": "sed",
    "idStudents": [
        20,
        4
    ],
    "idCourse": 19
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
    'http://localhost/api/school-delays',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'hour' => '14:46',
            'date' => '2025-11-22T14:46:54+0000',
            'description' => 'sed',
            'idStudents' => [
                20,
                4,
            ],
            'idCourse' => 19,
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
<div id="execution-results-POSTapi-school-delays" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-school-delays"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-school-delays"></code></pre>
</div>
<div id="execution-error-POSTapi-school-delays" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-school-delays"></code></pre>
</div>
<form id="form-POSTapi-school-delays" data-method="POST" data-path="api/school-delays" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-school-delays', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/school-delays</code></b>
</p>
<p>
<label id="auth-POSTapi-school-delays" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-school-delays" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>hour</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="hour" data-endpoint="POSTapi-school-delays" data-component="body" required  hidden>
<br>
The value must be a valid date in the format H:i.
</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-school-delays" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-school-delays" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudents</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idStudents.0" data-endpoint="POSTapi-school-delays" data-component="body" required  hidden>
<input type="number" name="idStudents.1" data-endpoint="POSTapi-school-delays" data-component="body" hidden>
<br>

</p>
<p>
<b><code>idCourse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idCourse" data-endpoint="POSTapi-school-delays" data-component="body"  hidden>
<br>

</p>

</form>


## Affiche les détails d&#039;un retard scolaire.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/school-delays/neque" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/school-delays/neque"
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
    'http://localhost/api/school-delays/neque',
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
<div id="execution-results-GETapi-school-delays--school_delay-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-school-delays--school_delay-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-school-delays--school_delay-"></code></pre>
</div>
<div id="execution-error-GETapi-school-delays--school_delay-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-school-delays--school_delay-"></code></pre>
</div>
<form id="form-GETapi-school-delays--school_delay-" data-method="GET" data-path="api/school-delays/{school_delay}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-school-delays--school_delay-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/school-delays/{school_delay}</code></b>
</p>
<p>
<label id="auth-GETapi-school-delays--school_delay-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-school-delays--school_delay-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>school_delay</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="school_delay" data-endpoint="GETapi-school-delays--school_delay-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour un retard scolaire existant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/school-delays/dolor" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"hour":"14:46","date":"2025-11-22T14:46:54+0000","description":"atque","idStudent":"magni","idCourse":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/school-delays/dolor"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "hour": "14:46",
    "date": "2025-11-22T14:46:54+0000",
    "description": "atque",
    "idStudent": "magni",
    "idCourse": {}
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
    'http://localhost/api/school-delays/dolor',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'hour' => '14:46',
            'date' => '2025-11-22T14:46:54+0000',
            'description' => 'atque',
            'idStudent' => 'magni',
            'idCourse' => [],
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
<div id="execution-results-PUTapi-school-delays--school_delay-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-school-delays--school_delay-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-school-delays--school_delay-"></code></pre>
</div>
<div id="execution-error-PUTapi-school-delays--school_delay-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-school-delays--school_delay-"></code></pre>
</div>
<form id="form-PUTapi-school-delays--school_delay-" data-method="PUT" data-path="api/school-delays/{school_delay}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-school-delays--school_delay-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/school-delays/{school_delay}</code></b>
</p>
<p>
<label id="auth-PUTapi-school-delays--school_delay-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-school-delays--school_delay-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>school_delay</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="school_delay" data-endpoint="PUTapi-school-delays--school_delay-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>hour</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="hour" data-endpoint="PUTapi-school-delays--school_delay-" data-component="body" required  hidden>
<br>
The value must be a valid date in the format H:i.
</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-school-delays--school_delay-" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-school-delays--school_delay-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idStudent" data-endpoint="PUTapi-school-delays--school_delay-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idCourse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idCourse" data-endpoint="PUTapi-school-delays--school_delay-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprime temporairement un ou plusieurs retards scolaires (mise à la corbeille).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/school-delays/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[2,9]}'

```

```javascript
const url = new URL(
    "http://localhost/api/school-delays/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        2,
        9
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
    'http://localhost/api/school-delays/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                2,
                9,
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
<div id="execution-results-POSTapi-school-delays-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-school-delays-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-school-delays-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-school-delays-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-school-delays-trash"></code></pre>
</div>
<form id="form-POSTapi-school-delays-trash" data-method="POST" data-path="api/school-delays/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-school-delays-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/school-delays/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-school-delays-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-school-delays-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-school-delays-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-school-delays-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure un ou plusieurs retards scolaires supprimés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/school-delays/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[16,12]}'

```

```javascript
const url = new URL(
    "http://localhost/api/school-delays/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        16,
        12
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
    'http://localhost/api/school-delays/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                16,
                12,
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
<div id="execution-results-POSTapi-school-delays-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-school-delays-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-school-delays-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-school-delays-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-school-delays-restore"></code></pre>
</div>
<form id="form-POSTapi-school-delays-restore" data-method="POST" data-path="api/school-delays/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-school-delays-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/school-delays/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-school-delays-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-school-delays-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-school-delays-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-school-delays-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement un ou plusieurs retards scolaires.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/school-delays/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[6,12]}'

```

```javascript
const url = new URL(
    "http://localhost/api/school-delays/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        6,
        12
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
    'http://localhost/api/school-delays/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                6,
                12,
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
<div id="execution-results-POSTapi-school-delays-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-school-delays-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-school-delays-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-school-delays-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-school-delays-delete"></code></pre>
</div>
<form id="form-POSTapi-school-delays-delete" data-method="POST" data-path="api/school-delays/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-school-delays-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/school-delays/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-school-delays-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-school-delays-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-school-delays-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-school-delays-delete" data-component="body" hidden>
<br>

</p>

</form>



