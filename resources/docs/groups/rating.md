# Rating


## Afficher la liste des notes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/ratingsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":11,"idSection":17,"idClasse":20,"idMatter":18,"idStudent":13,"idTeacher":12,"idAssessmentType":12,"idTypeEvaluation":11,"idAssessment":10,"idOptionLevel":1,"pageItems":20,"nbreItems":16}'

```

```javascript
const url = new URL(
    "http://localhost/api/ratingsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 11,
    "idSection": 17,
    "idClasse": 20,
    "idMatter": 18,
    "idStudent": 13,
    "idTeacher": 12,
    "idAssessmentType": 12,
    "idTypeEvaluation": 11,
    "idAssessment": 10,
    "idOptionLevel": 1,
    "pageItems": 20,
    "nbreItems": 16
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
    'http://localhost/api/ratingsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 11,
            'idSection' => 17,
            'idClasse' => 20,
            'idMatter' => 18,
            'idStudent' => 13,
            'idTeacher' => 12,
            'idAssessmentType' => 12,
            'idTypeEvaluation' => 11,
            'idAssessment' => 10,
            'idOptionLevel' => 1,
            'pageItems' => 20,
            'nbreItems' => 16,
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
<div id="execution-results-POSTapi-ratingsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-ratingsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-ratingsall"></code></pre>
</div>
<div id="execution-error-POSTapi-ratingsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-ratingsall"></code></pre>
</div>
<form id="form-POSTapi-ratingsall" data-method="POST" data-path="api/ratingsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-ratingsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/ratingsall</code></b>
</p>
<p>
<label id="auth-POSTapi-ratingsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-ratingsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-ratingsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeEvaluation</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeEvaluation" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessment</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessment" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-ratingsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;un rating(note)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/ratings/ullam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/ratings/ullam"
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
    'http://localhost/api/ratings/ullam',
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
<div id="execution-results-GETapi-ratings--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-ratings--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ratings--id-"></code></pre>
</div>
<div id="execution-error-GETapi-ratings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ratings--id-"></code></pre>
</div>
<form id="form-GETapi-ratings--id-" data-method="GET" data-path="api/ratings/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-ratings--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/ratings/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-ratings--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-ratings--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-ratings--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter une note

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/ratings" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/ratings"
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
    'http://localhost/api/ratings',
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
<div id="execution-results-POSTapi-ratings" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-ratings"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-ratings"></code></pre>
</div>
<div id="execution-error-POSTapi-ratings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-ratings"></code></pre>
</div>
<form id="form-POSTapi-ratings" data-method="POST" data-path="api/ratings" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-ratings', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/ratings</code></b>
</p>
<p>
<label id="auth-POSTapi-ratings" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-ratings" data-component="header"></label>
</p>
</form>


## maj des infos d&#039;un rating (note)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/ratings/voluptates" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/ratings/voluptates"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/ratings/voluptates',
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
<div id="execution-results-PUTapi-ratings--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-ratings--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-ratings--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-ratings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-ratings--id-"></code></pre>
</div>
<form id="form-PUTapi-ratings--id-" data-method="PUT" data-path="api/ratings/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-ratings--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/ratings/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-ratings--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-ratings--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-ratings--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un élément de rating

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/ratings/sed" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/ratings/sed"
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
    'http://localhost/api/ratings/sed',
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
<div id="execution-results-DELETEapi-ratings--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-ratings--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-ratings--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-ratings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-ratings--id-"></code></pre>
</div>
<form id="form-DELETEapi-ratings--id-" data-method="DELETE" data-path="api/ratings/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-ratings--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/ratings/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-ratings--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-ratings--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-ratings--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Effectuer une suppression multiple

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/ratings/bulk-delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ratingsids":["dolorum"]}'

```

```javascript
const url = new URL(
    "http://localhost/api/ratings/bulk-delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ratingsids": [
        "dolorum"
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
    'http://localhost/api/ratings/bulk-delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ratingsids' => [
                'dolorum',
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
<div id="execution-results-POSTapi-ratings-bulk-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-ratings-bulk-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-ratings-bulk-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-ratings-bulk-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-ratings-bulk-delete"></code></pre>
</div>
<form id="form-POSTapi-ratings-bulk-delete" data-method="POST" data-path="api/ratings/bulk-delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-ratings-bulk-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/ratings/bulk-delete</code></b>
</p>
<p>
<label id="auth-POSTapi-ratings-bulk-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-ratings-bulk-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ratingsids</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="ratingsids.0" data-endpoint="POSTapi-ratings-bulk-delete" data-component="body" required  hidden>
<input type="text" name="ratingsids.1" data-endpoint="POSTapi-ratings-bulk-delete" data-component="body" hidden>
<br>

</p>

</form>


## api/bulletin

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bulletin" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/bulletin"
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
    'http://localhost/api/bulletin',
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
<div id="execution-results-POSTapi-bulletin" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bulletin"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bulletin"></code></pre>
</div>
<div id="execution-error-POSTapi-bulletin" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bulletin"></code></pre>
</div>
<form id="form-POSTapi-bulletin" data-method="POST" data-path="api/bulletin" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bulletin', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bulletin</code></b>
</p>
<p>
<label id="auth-POSTapi-bulletin" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bulletin" data-component="header"></label>
</p>
</form>


## api/bulletinsecondaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bulletinsecondaire" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/bulletinsecondaire"
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
    'http://localhost/api/bulletinsecondaire',
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
<div id="execution-results-POSTapi-bulletinsecondaire" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bulletinsecondaire"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bulletinsecondaire"></code></pre>
</div>
<div id="execution-error-POSTapi-bulletinsecondaire" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bulletinsecondaire"></code></pre>
</div>
<form id="form-POSTapi-bulletinsecondaire" data-method="POST" data-path="api/bulletinsecondaire" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bulletinsecondaire', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bulletinsecondaire</code></b>
</p>
<p>
<label id="auth-POSTapi-bulletinsecondaire" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bulletinsecondaire" data-component="header"></label>
</p>
</form>


## api/bulletinsecondairefrancophone

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bulletinsecondairefrancophone" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/bulletinsecondairefrancophone"
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
    'http://localhost/api/bulletinsecondairefrancophone',
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
<div id="execution-results-POSTapi-bulletinsecondairefrancophone" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bulletinsecondairefrancophone"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bulletinsecondairefrancophone"></code></pre>
</div>
<div id="execution-error-POSTapi-bulletinsecondairefrancophone" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bulletinsecondairefrancophone"></code></pre>
</div>
<form id="form-POSTapi-bulletinsecondairefrancophone" data-method="POST" data-path="api/bulletinsecondairefrancophone" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bulletinsecondairefrancophone', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bulletinsecondairefrancophone</code></b>
</p>
<p>
<label id="auth-POSTapi-bulletinsecondairefrancophone" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bulletinsecondairefrancophone" data-component="header"></label>
</p>
</form>


## api/bulletinmaternelle

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/bulletinmaternelle" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/bulletinmaternelle"
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
    'http://localhost/api/bulletinmaternelle',
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
<div id="execution-results-POSTapi-bulletinmaternelle" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-bulletinmaternelle"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-bulletinmaternelle"></code></pre>
</div>
<div id="execution-error-POSTapi-bulletinmaternelle" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-bulletinmaternelle"></code></pre>
</div>
<form id="form-POSTapi-bulletinmaternelle" data-method="POST" data-path="api/bulletinmaternelle" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-bulletinmaternelle', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/bulletinmaternelle</code></b>
</p>
<p>
<label id="auth-POSTapi-bulletinmaternelle" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-bulletinmaternelle" data-component="header"></label>
</p>
</form>


## api/genererbulletinsecondairebulk

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/genererbulletinsecondairebulk" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/genererbulletinsecondairebulk"
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
    'http://localhost/api/genererbulletinsecondairebulk',
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
<div id="execution-results-POSTapi-genererbulletinsecondairebulk" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-genererbulletinsecondairebulk"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-genererbulletinsecondairebulk"></code></pre>
</div>
<div id="execution-error-POSTapi-genererbulletinsecondairebulk" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-genererbulletinsecondairebulk"></code></pre>
</div>
<form id="form-POSTapi-genererbulletinsecondairebulk" data-method="POST" data-path="api/genererbulletinsecondairebulk" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-genererbulletinsecondairebulk', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/genererbulletinsecondairebulk</code></b>
</p>
<p>
<label id="auth-POSTapi-genererbulletinsecondairebulk" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-genererbulletinsecondairebulk" data-component="header"></label>
</p>
</form>


## api/genererbulletinsecondairepersonnel

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/genererbulletinsecondairepersonnel" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":12,"idSection":7,"idStudent":2,"idClasse":2,"route":"suscipit","idTrimestre":19,"idAssessmentType":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/genererbulletinsecondairepersonnel"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 12,
    "idSection": 7,
    "idStudent": 2,
    "idClasse": 2,
    "route": "suscipit",
    "idTrimestre": 19,
    "idAssessmentType": 2
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
    'http://localhost/api/genererbulletinsecondairepersonnel',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 12,
            'idSection' => 7,
            'idStudent' => 2,
            'idClasse' => 2,
            'route' => 'suscipit',
            'idTrimestre' => 19,
            'idAssessmentType' => 2,
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
<div id="execution-results-POSTapi-genererbulletinsecondairepersonnel" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-genererbulletinsecondairepersonnel"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-genererbulletinsecondairepersonnel"></code></pre>
</div>
<div id="execution-error-POSTapi-genererbulletinsecondairepersonnel" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-genererbulletinsecondairepersonnel"></code></pre>
</div>
<form id="form-POSTapi-genererbulletinsecondairepersonnel" data-method="POST" data-path="api/genererbulletinsecondairepersonnel" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-genererbulletinsecondairepersonnel', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/genererbulletinsecondairepersonnel</code></b>
</p>
<p>
<label id="auth-POSTapi-genererbulletinsecondairepersonnel" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>route</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="route" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTrimestre</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTrimestre" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-genererbulletinsecondairepersonnel" data-component="body"  hidden>
<br>

</p>

</form>



