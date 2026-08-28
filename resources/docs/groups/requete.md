# Requete


## Lister les requêtes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/requetesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idTypeRequete":2,"statut":"odit","idSchool":12,"idSection":19,"idUser":18,"categorie":"hic","filter_value":{},"idStudent":15,"idParent":12,"type":"exercitationem","pageItems":9,"nbreItems":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/requetesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idTypeRequete": 2,
    "statut": "odit",
    "idSchool": 12,
    "idSection": 19,
    "idUser": 18,
    "categorie": "hic",
    "filter_value": {},
    "idStudent": 15,
    "idParent": 12,
    "type": "exercitationem",
    "pageItems": 9,
    "nbreItems": 4
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
    'http://localhost/api/requetesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idTypeRequete' => 2,
            'statut' => 'odit',
            'idSchool' => 12,
            'idSection' => 19,
            'idUser' => 18,
            'categorie' => 'hic',
            'filter_value' => [],
            'idStudent' => 15,
            'idParent' => 12,
            'type' => 'exercitationem',
            'pageItems' => 9,
            'nbreItems' => 4,
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
<div id="execution-results-POSTapi-requetesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-requetesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-requetesall"></code></pre>
</div>
<div id="execution-error-POSTapi-requetesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-requetesall"></code></pre>
</div>
<form id="form-POSTapi-requetesall" data-method="POST" data-path="api/requetesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-requetesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/requetesall</code></b>
</p>
<p>
<label id="auth-POSTapi-requetesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-requetesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idTypeRequete</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeRequete" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>enum:en_cours,valide,rejected</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>
Le statut de requêtes à sélectionner
</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>categorie</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="categorie" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idParent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idParent" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>
Le type de requêtes à sélectionner
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>
Le numéro de la page de pagination
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-requetesall" data-component="body"  hidden>
<br>
Le nombre de résultats pour la page de pagination
</p>

</form>


## Afficher les infos d&#039;une requête

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/requetes/15" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/requetes/15"
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
    'http://localhost/api/requetes/15',
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
<div id="execution-results-GETapi-requetes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-requetes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-requetes--id-"></code></pre>
</div>
<div id="execution-error-GETapi-requetes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-requetes--id-"></code></pre>
</div>
<form id="form-GETapi-requetes--id-" data-method="GET" data-path="api/requetes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-requetes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/requetes/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-requetes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-requetes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-requetes--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Enregistrer une nouvelle requête

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/requetes" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"categorie":"externe","description":"veniam","idTypeRequete":12,"statut":"valide","reponse":{},"idUser":14}'

```

```javascript
const url = new URL(
    "http://localhost/api/requetes"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "categorie": "externe",
    "description": "veniam",
    "idTypeRequete": 12,
    "statut": "valide",
    "reponse": {},
    "idUser": 14
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
    'http://localhost/api/requetes',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'categorie' => 'externe',
            'description' => 'veniam',
            'idTypeRequete' => 12,
            'statut' => 'valide',
            'reponse' => [],
            'idUser' => 14,
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
<div id="execution-results-POSTapi-requetes" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-requetes"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-requetes"></code></pre>
</div>
<div id="execution-error-POSTapi-requetes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-requetes"></code></pre>
</div>
<form id="form-POSTapi-requetes" data-method="POST" data-path="api/requetes" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-requetes', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/requetes</code></b>
</p>
<p>
<label id="auth-POSTapi-requetes" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-requetes" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>categorie</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="categorie" data-endpoint="POSTapi-requetes" data-component="body" required  hidden>
<br>
The value must be one of <code>interne</code> or <code>externe</code>.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-requetes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTypeRequete</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTypeRequete" data-endpoint="POSTapi-requetes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="POSTapi-requetes" data-component="body"  hidden>
<br>
The value must be one of <code>en_cours</code>, <code>valide</code>, or <code>rejected</code>.
</p>
<p>
<b><code>reponse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reponse" data-endpoint="POSTapi-requetes" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-requetes" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;une requête

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/requetes/7" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"categorie":"in","description":"rerum","statut":"vitae","idTypeRequete":12,"reponse":"doloribus","idStudent":1,"idParent":4,"idSection":5,"idSchool":17}'

```

```javascript
const url = new URL(
    "http://localhost/api/requetes/7"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "categorie": "in",
    "description": "rerum",
    "statut": "vitae",
    "idTypeRequete": 12,
    "reponse": "doloribus",
    "idStudent": 1,
    "idParent": 4,
    "idSection": 5,
    "idSchool": 17
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
    'http://localhost/api/requetes/7',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'categorie' => 'in',
            'description' => 'rerum',
            'statut' => 'vitae',
            'idTypeRequete' => 12,
            'reponse' => 'doloribus',
            'idStudent' => 1,
            'idParent' => 4,
            'idSection' => 5,
            'idSchool' => 17,
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
<div id="execution-results-PUTapi-requetes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-requetes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-requetes--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-requetes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-requetes--id-"></code></pre>
</div>
<form id="form-PUTapi-requetes--id-" data-method="PUT" data-path="api/requetes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-requetes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/requetes/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-requetes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-requetes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-requetes--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>categorie</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="categorie" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeRequete</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeRequete" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reponse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reponse" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idParent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idParent" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-requetes--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer une requête

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/requetes/fuga" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/requetes/fuga"
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
    'http://localhost/api/requetes/fuga',
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
<div id="execution-results-DELETEapi-requetes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-requetes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-requetes--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-requetes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-requetes--id-"></code></pre>
</div>
<form id="form-DELETEapi-requetes--id-" data-method="DELETE" data-path="api/requetes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-requetes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/requetes/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-requetes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-requetes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-requetes--id-" data-component="url" required  hidden>
<br>

</p>
</form>



