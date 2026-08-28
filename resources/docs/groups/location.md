# Location


## Lister les locations

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/locationsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":18,"idSection":16,"status":"in_progress","idUser":3,"pageItems":1,"nbreItems":20,"filter_value":"delectus"}'

```

```javascript
const url = new URL(
    "http://localhost/api/locationsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 18,
    "idSection": 16,
    "status": "in_progress",
    "idUser": 3,
    "pageItems": 1,
    "nbreItems": 20,
    "filter_value": "delectus"
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
    'http://localhost/api/locationsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 18,
            'idSection' => 16,
            'status' => 'in_progress',
            'idUser' => 3,
            'pageItems' => 1,
            'nbreItems' => 20,
            'filter_value' => 'delectus',
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
<div id="execution-results-POSTapi-locationsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-locationsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-locationsall"></code></pre>
</div>
<div id="execution-error-POSTapi-locationsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-locationsall"></code></pre>
</div>
<form id="form-POSTapi-locationsall" data-method="POST" data-path="api/locationsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-locationsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/locationsall</code></b>
</p>
<p>
<label id="auth-POSTapi-locationsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-locationsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>
The value must be one of <code>in_progress</code> or <code>finished</code>.
</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-locationsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une location

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/locations/9" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/locations/9"
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
    'http://localhost/api/locations/9',
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
<div id="execution-results-GETapi-locations--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-locations--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-locations--id-"></code></pre>
</div>
<div id="execution-error-GETapi-locations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-locations--id-"></code></pre>
</div>
<form id="form-GETapi-locations--id-" data-method="GET" data-path="api/locations/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-locations--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/locations/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-locations--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-locations--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-locations--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Enregistrer une nouvelle location de livre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/locations" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":15,"idBook":15,"date_sortie":"2025-11-22T14:46:45+0000","date_retour":"2025-11-22T14:46:45+0000","reason":"labore","observation":"rerum","status":"finished"}'

```

```javascript
const url = new URL(
    "http://localhost/api/locations"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 15,
    "idBook": 15,
    "date_sortie": "2025-11-22T14:46:45+0000",
    "date_retour": "2025-11-22T14:46:45+0000",
    "reason": "labore",
    "observation": "rerum",
    "status": "finished"
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
    'http://localhost/api/locations',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 15,
            'idBook' => 15,
            'date_sortie' => '2025-11-22T14:46:45+0000',
            'date_retour' => '2025-11-22T14:46:45+0000',
            'reason' => 'labore',
            'observation' => 'rerum',
            'status' => 'finished',
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
<div id="execution-results-POSTapi-locations" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-locations"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-locations"></code></pre>
</div>
<div id="execution-error-POSTapi-locations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-locations"></code></pre>
</div>
<form id="form-POSTapi-locations" data-method="POST" data-path="api/locations" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-locations', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/locations</code></b>
</p>
<p>
<label id="auth-POSTapi-locations" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-locations" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idBook</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idBook" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>date_sortie</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date_sortie" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_retour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_retour" data-endpoint="POSTapi-locations" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-locations" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>observation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="observation" data-endpoint="POSTapi-locations" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-locations" data-component="body"  hidden>
<br>
The value must be one of <code>in_progress</code> or <code>finished</code>.
</p>

</form>


## maj des infos d&#039;un location

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/locations/19" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":9,"idBook":12,"date_sortie":"2025-11-22T14:46:45+0000","date_retour":"2025-11-22T14:46:45+0000","reason":"numquam","observation":"at","status":"finished"}'

```

```javascript
const url = new URL(
    "http://localhost/api/locations/19"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 9,
    "idBook": 12,
    "date_sortie": "2025-11-22T14:46:45+0000",
    "date_retour": "2025-11-22T14:46:45+0000",
    "reason": "numquam",
    "observation": "at",
    "status": "finished"
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
    'http://localhost/api/locations/19',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 9,
            'idBook' => 12,
            'date_sortie' => '2025-11-22T14:46:45+0000',
            'date_retour' => '2025-11-22T14:46:45+0000',
            'reason' => 'numquam',
            'observation' => 'at',
            'status' => 'finished',
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
<div id="execution-results-PUTapi-locations--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-locations--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-locations--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-locations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-locations--id-"></code></pre>
</div>
<form id="form-PUTapi-locations--id-" data-method="PUT" data-path="api/locations/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-locations--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/locations/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-locations--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-locations--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-locations--id-" data-component="url"  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-locations--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idBook</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idBook" data-endpoint="PUTapi-locations--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>date_sortie</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date_sortie" data-endpoint="PUTapi-locations--id-" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_retour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_retour" data-endpoint="PUTapi-locations--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-locations--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>observation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="observation" data-endpoint="PUTapi-locations--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-locations--id-" data-component="body"  hidden>
<br>
The value must be one of <code>in_progress</code> or <code>finished</code>.
</p>

</form>


## Supprimer une location de livres

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/locations/8" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/locations/8"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/locations/8',
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
<div id="execution-results-DELETEapi-locations--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-locations--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-locations--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-locations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-locations--id-"></code></pre>
</div>
<form id="form-DELETEapi-locations--id-" data-method="DELETE" data-path="api/locations/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-locations--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/locations/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-locations--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-locations--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="DELETEapi-locations--id-" data-component="url" required  hidden>
<br>

</p>
</form>



