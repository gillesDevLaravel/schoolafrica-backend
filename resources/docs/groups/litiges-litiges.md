# Litiges / Litiges

Gestion des Litiges

## Afficher la liste des litiges

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/litigesall?isAnonymous=1&user_id=1&filter_value=paiement&pageItems=1&nbreItems=50" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"quia","nbreItems":19,"pageItems":16,"isAnonymous":false,"date_start":"2026-03-04T18:39:15+0000","date_end":"2026-03-04T18:39:15+0000","user_id":8}'

```

```javascript
const url = new URL(
    "http://localhost/api/litigesall"
);

let params = {
    "isAnonymous": "1",
    "user_id": "1",
    "filter_value": "paiement",
    "pageItems": "1",
    "nbreItems": "50",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "quia",
    "nbreItems": 19,
    "pageItems": 16,
    "isAnonymous": false,
    "date_start": "2026-03-04T18:39:15+0000",
    "date_end": "2026-03-04T18:39:15+0000",
    "user_id": 8
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
    'http://localhost/api/litigesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'query' => [
            'isAnonymous'=> '1',
            'user_id'=> '1',
            'filter_value'=> 'paiement',
            'pageItems'=> '1',
            'nbreItems'=> '50',
        ],
        'json' => [
            'filter_value' => 'quia',
            'nbreItems' => 19,
            'pageItems' => 16,
            'isAnonymous' => false,
            'date_start' => '2026-03-04T18:39:15+0000',
            'date_end' => '2026-03-04T18:39:15+0000',
            'user_id' => 8,
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
<div id="execution-results-POSTapi-litigesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-litigesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-litigesall"></code></pre>
</div>
<div id="execution-error-POSTapi-litigesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-litigesall"></code></pre>
</div>
<form id="form-POSTapi-litigesall" data-method="POST" data-path="api/litigesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-litigesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/litigesall</code></b>
</p>
<p>
<label id="auth-POSTapi-litigesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-litigesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>isAnonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-litigesall" hidden><input type="radio" name="isAnonymous" value="1" data-endpoint="POSTapi-litigesall" data-component="query" ><code>true</code></label>
<label data-endpoint="POSTapi-litigesall" hidden><input type="radio" name="isAnonymous" value="0" data-endpoint="POSTapi-litigesall" data-component="query" ><code>false</code></label>
<br>
Filtre par anonymat.
</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-litigesall" data-component="query"  hidden>
<br>
Filtre par ID d'utilisateur.
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-litigesall" data-component="query"  hidden>
<br>
Recherche sur le nom ou la description.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-litigesall" data-component="query"  hidden>
<br>
Numéro de page.
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-litigesall" data-component="query"  hidden>
<br>
Nombre d'éléments par page.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-litigesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-litigesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-litigesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>isAnonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-litigesall" hidden><input type="radio" name="isAnonymous" value="true" data-endpoint="POSTapi-litigesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-litigesall" hidden><input type="radio" name="isAnonymous" value="false" data-endpoint="POSTapi-litigesall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-litigesall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-litigesall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-litigesall" data-component="body"  hidden>
<br>

</p>

</form>


## Créer un litige

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/litiges" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Probl\u00e8me de facturation","description":"Le montant factur\u00e9 ne correspond pas au montant convenu.","answer":"Le montant sera ajust\u00e9 dans la prochaine facture.","user_id":2,"is_anonymous":false,"statut":"nouveau"}'

```

```javascript
const url = new URL(
    "http://localhost/api/litiges"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Probl\u00e8me de facturation",
    "description": "Le montant factur\u00e9 ne correspond pas au montant convenu.",
    "answer": "Le montant sera ajust\u00e9 dans la prochaine facture.",
    "user_id": 2,
    "is_anonymous": false,
    "statut": "nouveau"
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
    'http://localhost/api/litiges',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'Problème de facturation',
            'description' => 'Le montant facturé ne correspond pas au montant convenu.',
            'answer' => 'Le montant sera ajusté dans la prochaine facture.',
            'user_id' => 2,
            'is_anonymous' => false,
            'statut' => 'nouveau',
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
<div id="execution-results-POSTapi-litiges" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-litiges"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-litiges"></code></pre>
</div>
<div id="execution-error-POSTapi-litiges" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-litiges"></code></pre>
</div>
<form id="form-POSTapi-litiges" data-method="POST" data-path="api/litiges" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-litiges', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/litiges</code></b>
</p>
<p>
<label id="auth-POSTapi-litiges" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-litiges" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-litiges" data-component="body"  hidden>
<br>
Nom du litige.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-litiges" data-component="body" required  hidden>
<br>
Description détaillée du litige.
</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="answer" data-endpoint="POSTapi-litiges" data-component="body"  hidden>
<br>
Réponse au litige.
</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="POSTapi-litiges" data-component="body"  hidden>
<br>
ID de l'utilisateur concerné.
</p>
<p>
<b><code>is_anonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-litiges" hidden><input type="radio" name="is_anonymous" value="true" data-endpoint="POSTapi-litiges" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-litiges" hidden><input type="radio" name="is_anonymous" value="false" data-endpoint="POSTapi-litiges" data-component="body" ><code>false</code></label>
<br>
Si le litige est anonyme.
</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="POSTapi-litiges" data-component="body"  hidden>
<br>
Statut du litige.
</p>

</form>


## Afficher un litige

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/litiges/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/litiges/12"
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
    'http://localhost/api/litiges/12',
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
<div id="execution-results-GETapi-litiges--litige-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-litiges--litige-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-litiges--litige-"></code></pre>
</div>
<div id="execution-error-GETapi-litiges--litige-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-litiges--litige-"></code></pre>
</div>
<form id="form-GETapi-litiges--litige-" data-method="GET" data-path="api/litiges/{litige}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-litiges--litige-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/litiges/{litige}</code></b>
</p>
<p>
<label id="auth-GETapi-litiges--litige-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-litiges--litige-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>litige</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="litige" data-endpoint="GETapi-litiges--litige-" data-component="url" required  hidden>
<br>
ID du litige.
</p>
</form>


## Mettre à jour un litige

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/litiges/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Probl\u00e8me de facturation","description":"Le montant factur\u00e9 ne correspond pas au montant convenu.","answer":"Le montant sera ajust\u00e9 dans la prochaine facture.","user_id":2,"is_anonymous":false,"statut":"en_cours"}'

```

```javascript
const url = new URL(
    "http://localhost/api/litiges/12"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Probl\u00e8me de facturation",
    "description": "Le montant factur\u00e9 ne correspond pas au montant convenu.",
    "answer": "Le montant sera ajust\u00e9 dans la prochaine facture.",
    "user_id": 2,
    "is_anonymous": false,
    "statut": "en_cours"
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
    'http://localhost/api/litiges/12',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'Problème de facturation',
            'description' => 'Le montant facturé ne correspond pas au montant convenu.',
            'answer' => 'Le montant sera ajusté dans la prochaine facture.',
            'user_id' => 2,
            'is_anonymous' => false,
            'statut' => 'en_cours',
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
<div id="execution-results-PUTapi-litiges--litige-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-litiges--litige-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-litiges--litige-"></code></pre>
</div>
<div id="execution-error-PUTapi-litiges--litige-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-litiges--litige-"></code></pre>
</div>
<form id="form-PUTapi-litiges--litige-" data-method="PUT" data-path="api/litiges/{litige}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-litiges--litige-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/litiges/{litige}</code></b>
</p>
<p>
<label id="auth-PUTapi-litiges--litige-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-litiges--litige-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>litige</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="litige" data-endpoint="PUTapi-litiges--litige-" data-component="url" required  hidden>
<br>
ID du litige.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-litiges--litige-" data-component="body"  hidden>
<br>
Nom du litige.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-litiges--litige-" data-component="body"  hidden>
<br>
Description détaillée du litige.
</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="answer" data-endpoint="PUTapi-litiges--litige-" data-component="body"  hidden>
<br>
Réponse au litige.
</p>
<p>
<b><code>user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="user_id" data-endpoint="PUTapi-litiges--litige-" data-component="body"  hidden>
<br>
ID de l'utilisateur concerné.
</p>
<p>
<b><code>is_anonymous</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-litiges--litige-" hidden><input type="radio" name="is_anonymous" value="true" data-endpoint="PUTapi-litiges--litige-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-litiges--litige-" hidden><input type="radio" name="is_anonymous" value="false" data-endpoint="PUTapi-litiges--litige-" data-component="body" ><code>false</code></label>
<br>
Si le litige est anonyme.
</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="PUTapi-litiges--litige-" data-component="body"  hidden>
<br>
Statut du litige.
</p>

</form>


## Archiver des litiges (soft delete)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/litiges/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/litiges/trash"
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
    'http://localhost/api/litiges/trash',
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
<div id="execution-results-POSTapi-litiges-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-litiges-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-litiges-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-litiges-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-litiges-trash"></code></pre>
</div>
<form id="form-POSTapi-litiges-trash" data-method="POST" data-path="api/litiges/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-litiges-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/litiges/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-litiges-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-litiges-trash" data-component="header"></label>
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
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-litiges-trash" data-component="body"  hidden>
<br>
ID d'un litige existant.
</p>
</details>
</p>

</form>


## Restaurer des litiges archivés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/litiges/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/litiges/restore"
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
    'http://localhost/api/litiges/restore',
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
<div id="execution-results-POSTapi-litiges-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-litiges-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-litiges-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-litiges-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-litiges-restore"></code></pre>
</div>
<form id="form-POSTapi-litiges-restore" data-method="POST" data-path="api/litiges/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-litiges-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/litiges/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-litiges-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-litiges-restore" data-component="header"></label>
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
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-litiges-restore" data-component="body"  hidden>
<br>
ID d'un litige existant.
</p>
</details>
</p>

</form>


## Supprimer définitivement des litiges

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/litiges/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"[1,2,3]"}'

```

```javascript
const url = new URL(
    "http://localhost/api/litiges/delete"
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
    'http://localhost/api/litiges/delete',
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
<div id="execution-results-POSTapi-litiges-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-litiges-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-litiges-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-litiges-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-litiges-delete"></code></pre>
</div>
<form id="form-POSTapi-litiges-delete" data-method="POST" data-path="api/litiges/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-litiges-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/litiges/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-litiges-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-litiges-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>ids</code></b>&nbsp;&nbsp;<small>array</small>  &nbsp;
<br>
Liste des IDs à supprimer définitivement.
</summary>
<br>
<p>
<b><code>ids.*</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.*" data-endpoint="POSTapi-litiges-delete" data-component="body"  hidden>
<br>
ID d'un litige existant.
</p>
</details>
</p>

</form>



