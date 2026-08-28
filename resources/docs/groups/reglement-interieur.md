# reglement_interieur


## Lister les éléments du règlement intérieur non supprimés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/reglements-interieursall?type=discipline&filter_value=r%C3%A8gle&pageItems=1&nbreItems=20" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"dolorem","pageItems":5,"nbreItems":1,"filter_value":"mollitia"}'

```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieursall"
);

let params = {
    "type": "discipline",
    "filter_value": "règle",
    "pageItems": "1",
    "nbreItems": "20",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "dolorem",
    "pageItems": 5,
    "nbreItems": 1,
    "filter_value": "mollitia"
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
    'http://localhost/api/reglements-interieursall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'query' => [
            'type'=> 'discipline',
            'filter_value'=> 'règle',
            'pageItems'=> '1',
            'nbreItems'=> '20',
        ],
        'json' => [
            'type' => 'dolorem',
            'pageItems' => 5,
            'nbreItems' => 1,
            'filter_value' => 'mollitia',
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
<div id="execution-results-POSTapi-reglements-interieursall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reglements-interieursall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reglements-interieursall"></code></pre>
</div>
<div id="execution-error-POSTapi-reglements-interieursall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reglements-interieursall"></code></pre>
</div>
<form id="form-POSTapi-reglements-interieursall" data-method="POST" data-path="api/reglements-interieursall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reglements-interieursall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reglements-interieursall</code></b>
</p>
<p>
<label id="auth-POSTapi-reglements-interieursall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-reglements-interieursall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-reglements-interieursall" data-component="query"  hidden>
<br>
nullable Filtre par type de règlement.
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-reglements-interieursall" data-component="query"  hidden>
<br>
nullable Filtre par titre ou description.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-reglements-interieursall" data-component="query"  hidden>
<br>
nullable Numéro de la page.
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-reglements-interieursall" data-component="query"  hidden>
<br>
nullable Nombre d'éléments par page.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-reglements-interieursall" data-component="body"  hidden>
<br>

</p>

</form>


## Enregistrer une ou plusieurs éléments du règlement intérieur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/reglements-interieurs" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"reglements_interieurs":"[{\"title\": \"R\u00e8gle 1\", \"description\": \"Description\", \"type\": \"discipline\", \"image\": \"url.jpg\", \"idSchool\": 1}]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "reglements_interieurs": "[{\"title\": \"R\u00e8gle 1\", \"description\": \"Description\", \"type\": \"discipline\", \"image\": \"url.jpg\", \"idSchool\": 1}]"
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
    'http://localhost/api/reglements-interieurs',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'reglements_interieurs' => '[{"title": "Règle 1", "description": "Description", "type": "discipline", "image": "url.jpg", "idSchool": 1}]',
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
<div id="execution-results-POSTapi-reglements-interieurs" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reglements-interieurs"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reglements-interieurs"></code></pre>
</div>
<div id="execution-error-POSTapi-reglements-interieurs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reglements-interieurs"></code></pre>
</div>
<form id="form-POSTapi-reglements-interieurs" data-method="POST" data-path="api/reglements-interieurs" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reglements-interieurs', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reglements-interieurs</code></b>
</p>
<p>
<label id="auth-POSTapi-reglements-interieurs" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-reglements-interieurs" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>reglements_interieurs</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Tableau des règlements intérieurs à créer.
</summary>
<br>
<p>
<b><code>reglements_interieurs[].title</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reglements_interieurs.0.title" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reglements_interieurs.0.description" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reglements_interieurs.0.type" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reglements_interieurs.0.image" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="reglements_interieurs.0.idSchool" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reglements_interieurs[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="reglements_interieurs.0.idSection" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>reglements_interieurs.*</code></b>&nbsp;&nbsp;<small>object</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>reglements_interieurs.*.title</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reglements_interieurs.*.title" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>
Titre du règlement.
</p>
<p>
<b><code>reglements_interieurs.*.description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reglements_interieurs.*.description" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>
Description du règlement.
</p>
<p>
<b><code>reglements_interieurs.*.type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reglements_interieurs.*.type" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>
nullable Type du règlement.
</p>
<p>
<b><code>reglements_interieurs.*.image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reglements_interieurs.*.image" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>
nullable URL de l'image associée.
</p>
<p>
<b><code>reglements_interieurs.*.idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="reglements_interieurs.*.idSchool" data-endpoint="POSTapi-reglements-interieurs" data-component="body" required  hidden>
<br>
ID de l'école.
</p>
<p>
<b><code>reglements_interieurs.*.idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="reglements_interieurs.*.idSection" data-endpoint="POSTapi-reglements-interieurs" data-component="body"  hidden>
<br>
nullable ID de la section.
</p>
</details>
</p>

</details>
</p>

</form>


## Afficher les détails d&#039;un élément du règlement intérieur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/reglements-interieurs/vero" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/vero"
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
    'http://localhost/api/reglements-interieurs/vero',
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
<div id="execution-results-GETapi-reglements-interieurs--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-reglements-interieurs--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-reglements-interieurs--id-"></code></pre>
</div>
<div id="execution-error-GETapi-reglements-interieurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-reglements-interieurs--id-"></code></pre>
</div>
<form id="form-GETapi-reglements-interieurs--id-" data-method="GET" data-path="api/reglements-interieurs/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-reglements-interieurs--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/reglements-interieurs/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-reglements-interieurs--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-reglements-interieurs--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-reglements-interieurs--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;un projet

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/reglements-interieurs/voluptates" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"R\u00e8gle modifi\u00e9e","description":"Description modifi\u00e9e","type":"discipline","image":"https:\/\/example.com\/image.jpg","idSchool":1,"idSection":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/voluptates"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "R\u00e8gle modifi\u00e9e",
    "description": "Description modifi\u00e9e",
    "type": "discipline",
    "image": "https:\/\/example.com\/image.jpg",
    "idSchool": 1,
    "idSection": 1
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
    'http://localhost/api/reglements-interieurs/voluptates',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'title' => 'Règle modifiée',
            'description' => 'Description modifiée',
            'type' => 'discipline',
            'image' => 'https://example.com/image.jpg',
            'idSchool' => 1,
            'idSection' => 1,
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
<div id="execution-results-PUTapi-reglements-interieurs--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-reglements-interieurs--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-reglements-interieurs--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-reglements-interieurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-reglements-interieurs--id-"></code></pre>
</div>
<form id="form-PUTapi-reglements-interieurs--id-" data-method="PUT" data-path="api/reglements-interieurs/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-reglements-interieurs--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/reglements-interieurs/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-reglements-interieurs--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-reglements-interieurs--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>title</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="title" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>
nullable Titre du règlement.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>
nullable Description du règlement.
</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>
nullable Type du règlement.
</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>
nullable URL de l'image associée.
</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>
nullable ID de l'école.
</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-reglements-interieurs--id-" data-component="body"  hidden>
<br>
nullable ID de la section.
</p>

</form>


## Envoyer un élément du règlement intérieur à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/reglements-interieurs/trash/ut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/trash/ut"
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
    'http://localhost/api/reglements-interieurs/trash/ut',
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
<div id="execution-results-DELETEapi-reglements-interieurs-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-reglements-interieurs-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-reglements-interieurs-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-reglements-interieurs-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-reglements-interieurs-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-reglements-interieurs-trash--id-" data-method="DELETE" data-path="api/reglements-interieurs/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-reglements-interieurs-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/reglements-interieurs/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-reglements-interieurs-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-reglements-interieurs-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-reglements-interieurs-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un élément du règlement intérieur de la corbeille
NB: Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/reglements-interieurs/restore/nobis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reglements-interieurs/restore/nobis"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/reglements-interieurs/restore/nobis',
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
<div id="execution-results-POSTapi-reglements-interieurs-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reglements-interieurs-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reglements-interieurs-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-reglements-interieurs-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reglements-interieurs-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-reglements-interieurs-restore--id-" data-method="POST" data-path="api/reglements-interieurs/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reglements-interieurs-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reglements-interieurs/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-reglements-interieurs-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-reglements-interieurs-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-reglements-interieurs-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>



