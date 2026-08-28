# School

Gestion de l'école

## Afficher la liste des écoles

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schoolsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schoolsall"
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
    'http://localhost/api/schoolsall',
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
<div id="execution-results-POSTapi-schoolsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schoolsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schoolsall"></code></pre>
</div>
<div id="execution-error-POSTapi-schoolsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schoolsall"></code></pre>
</div>
<form id="form-POSTapi-schoolsall" data-method="POST" data-path="api/schoolsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schoolsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schoolsall</code></b>
</p>
<p>
<label id="auth-POSTapi-schoolsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schoolsall" data-component="header"></label>
</p>
</form>


## Afficher les infos d&#039;une école

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/schools/totam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schools/totam"
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
    'http://localhost/api/schools/totam',
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
<div id="execution-results-GETapi-schools--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-schools--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-schools--id-"></code></pre>
</div>
<div id="execution-error-GETapi-schools--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-schools--id-"></code></pre>
</div>
<form id="form-GETapi-schools--id-" data-method="GET" data-path="api/schools/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-schools--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/schools/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-schools--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-schools--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-schools--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter une école

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schools" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"cupiditate","phone":"aut","adresse":"reiciendis","city":"repellat","section":"voluptates","scholar_level":"assumenda","idEstablishment":"fugiat","idAdjoint":{},"idSecretary":{},"idAssistant":{},"matricule_code":"ut"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "cupiditate",
    "phone": "aut",
    "adresse": "reiciendis",
    "city": "repellat",
    "section": "voluptates",
    "scholar_level": "assumenda",
    "idEstablishment": "fugiat",
    "idAdjoint": {},
    "idSecretary": {},
    "idAssistant": {},
    "matricule_code": "ut"
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
    'http://localhost/api/schools',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'cupiditate',
            'phone' => 'aut',
            'adresse' => 'reiciendis',
            'city' => 'repellat',
            'section' => 'voluptates',
            'scholar_level' => 'assumenda',
            'idEstablishment' => 'fugiat',
            'idAdjoint' => [],
            'idSecretary' => [],
            'idAssistant' => [],
            'matricule_code' => 'ut',
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
<div id="execution-results-POSTapi-schools" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schools"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schools"></code></pre>
</div>
<div id="execution-error-POSTapi-schools" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schools"></code></pre>
</div>
<form id="form-POSTapi-schools" data-method="POST" data-path="api/schools" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schools', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schools</code></b>
</p>
<p>
<label id="auth-POSTapi-schools" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schools" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>adresse</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="adresse" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>city</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="city" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>section</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="section" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scholar_level</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="scholar_level" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idEstablishment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idEstablishment" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAdjoint</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idAdjoint" data-endpoint="POSTapi-schools" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSecretary</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSecretary" data-endpoint="POSTapi-schools" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssistant</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idAssistant" data-endpoint="POSTapi-schools" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>matricule_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="matricule_code" data-endpoint="POSTapi-schools" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;une école

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/schools/voluptas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"reprehenderit","phone":"et","adresse":"exercitationem","city":"ipsa","section":"ullam","scholar_level":"ut","idEstablishment":"corrupti","idAdjoint":{},"idSecretary":{},"idAssistant":{},"matricule_code":"sed"}'

```

```javascript
const url = new URL(
    "http://localhost/api/schools/voluptas"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "reprehenderit",
    "phone": "et",
    "adresse": "exercitationem",
    "city": "ipsa",
    "section": "ullam",
    "scholar_level": "ut",
    "idEstablishment": "corrupti",
    "idAdjoint": {},
    "idSecretary": {},
    "idAssistant": {},
    "matricule_code": "sed"
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
    'http://localhost/api/schools/voluptas',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'reprehenderit',
            'phone' => 'et',
            'adresse' => 'exercitationem',
            'city' => 'ipsa',
            'section' => 'ullam',
            'scholar_level' => 'ut',
            'idEstablishment' => 'corrupti',
            'idAdjoint' => [],
            'idSecretary' => [],
            'idAssistant' => [],
            'matricule_code' => 'sed',
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
<div id="execution-results-PUTapi-schools--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-schools--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-schools--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-schools--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-schools--id-"></code></pre>
</div>
<form id="form-PUTapi-schools--id-" data-method="PUT" data-path="api/schools/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-schools--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/schools/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-schools--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-schools--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-schools--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>adresse</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="adresse" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>city</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="city" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>section</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="section" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scholar_level</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="scholar_level" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idEstablishment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idEstablishment" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAdjoint</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idAdjoint" data-endpoint="PUTapi-schools--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSecretary</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSecretary" data-endpoint="PUTapi-schools--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssistant</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idAssistant" data-endpoint="PUTapi-schools--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>matricule_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="matricule_code" data-endpoint="PUTapi-schools--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Supprimer une école

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/schools/dolorem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schools/dolorem"
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
    'http://localhost/api/schools/dolorem',
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
<div id="execution-results-DELETEapi-schools--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-schools--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-schools--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-schools--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-schools--id-"></code></pre>
</div>
<form id="form-DELETEapi-schools--id-" data-method="DELETE" data-path="api/schools/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-schools--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/schools/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-schools--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-schools--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-schools--id-" data-component="url" required  hidden>
<br>

</p>
</form>



