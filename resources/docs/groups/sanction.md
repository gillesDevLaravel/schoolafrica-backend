# Sanction


## Listing des sanctions

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/sanctionsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":15,"idSection":4,"idUser":19,"type":5,"typeUser":"staff","pageItems":2,"nbreItems":18,"filter_value":"veritatis","idClasse":2,"date":"2025-11-22T14:46:42+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/sanctionsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 15,
    "idSection": 4,
    "idUser": 19,
    "type": 5,
    "typeUser": "staff",
    "pageItems": 2,
    "nbreItems": 18,
    "filter_value": "veritatis",
    "idClasse": 2,
    "date": "2025-11-22T14:46:42+0000"
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
    'http://localhost/api/sanctionsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 15,
            'idSection' => 4,
            'idUser' => 19,
            'type' => 5,
            'typeUser' => 'staff',
            'pageItems' => 2,
            'nbreItems' => 18,
            'filter_value' => 'veritatis',
            'idClasse' => 2,
            'date' => '2025-11-22T14:46:42+0000',
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
<div id="execution-results-POSTapi-sanctionsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-sanctionsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-sanctionsall"></code></pre>
</div>
<div id="execution-error-POSTapi-sanctionsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-sanctionsall"></code></pre>
</div>
<form id="form-POSTapi-sanctionsall" data-method="POST" data-path="api/sanctionsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-sanctionsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/sanctionsall</code></b>
</p>
<p>
<label id="auth-POSTapi-sanctionsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-sanctionsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="type" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>typeUser</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="typeUser" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>
The value must be one of <code>staff</code> or <code>student</code>.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-sanctionsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## Afficher les infos d&#039;une sanction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/sanctions/saepe" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/sanctions/saepe"
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
    'http://localhost/api/sanctions/saepe',
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
<div id="execution-results-GETapi-sanctions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-sanctions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-sanctions--id-"></code></pre>
</div>
<div id="execution-error-GETapi-sanctions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-sanctions--id-"></code></pre>
</div>
<form id="form-GETapi-sanctions--id-" data-method="GET" data-path="api/sanctions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-sanctions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/sanctions/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-sanctions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-sanctions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-sanctions--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter une sanction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/sanctions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"description":"cum","idUser":"tempora","type":"assumenda","typeUser":"student","reasons":"porro"}'

```

```javascript
const url = new URL(
    "http://localhost/api/sanctions"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "description": "cum",
    "idUser": "tempora",
    "type": "assumenda",
    "typeUser": "student",
    "reasons": "porro"
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
    'http://localhost/api/sanctions',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'description' => 'cum',
            'idUser' => 'tempora',
            'type' => 'assumenda',
            'typeUser' => 'student',
            'reasons' => 'porro',
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
<div id="execution-results-POSTapi-sanctions" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-sanctions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-sanctions"></code></pre>
</div>
<div id="execution-error-POSTapi-sanctions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-sanctions"></code></pre>
</div>
<form id="form-POSTapi-sanctions" data-method="POST" data-path="api/sanctions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-sanctions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/sanctions</code></b>
</p>
<p>
<label id="auth-POSTapi-sanctions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-sanctions" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-sanctions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idUser" data-endpoint="POSTapi-sanctions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-sanctions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>typeUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="typeUser" data-endpoint="POSTapi-sanctions" data-component="body" required  hidden>
<br>
The value must be one of <code>staff</code> or <code>student</code>.
</p>
<p>
<b><code>reasons</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reasons" data-endpoint="POSTapi-sanctions" data-component="body" required  hidden>
<br>

</p>

</form>


## maj des infos d&#039;une sanction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/sanctions/explicabo" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"description":"inventore","idUser":"aut","type":"nemo","typeUser":"student","reasons":"doloremque"}'

```

```javascript
const url = new URL(
    "http://localhost/api/sanctions/explicabo"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "description": "inventore",
    "idUser": "aut",
    "type": "nemo",
    "typeUser": "student",
    "reasons": "doloremque"
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
    'http://localhost/api/sanctions/explicabo',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'description' => 'inventore',
            'idUser' => 'aut',
            'type' => 'nemo',
            'typeUser' => 'student',
            'reasons' => 'doloremque',
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
<div id="execution-results-PUTapi-sanctions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-sanctions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-sanctions--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-sanctions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-sanctions--id-"></code></pre>
</div>
<form id="form-PUTapi-sanctions--id-" data-method="PUT" data-path="api/sanctions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-sanctions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/sanctions/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-sanctions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-sanctions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-sanctions--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-sanctions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idUser" data-endpoint="PUTapi-sanctions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-sanctions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>typeUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="typeUser" data-endpoint="PUTapi-sanctions--id-" data-component="body" required  hidden>
<br>
The value must be one of <code>staff</code> or <code>student</code>.
</p>
<p>
<b><code>reasons</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reasons" data-endpoint="PUTapi-sanctions--id-" data-component="body" required  hidden>
<br>

</p>

</form>


## Supprimer une sanction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/sanctions/perferendis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/sanctions/perferendis"
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
    'http://localhost/api/sanctions/perferendis',
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
<div id="execution-results-DELETEapi-sanctions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-sanctions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-sanctions--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-sanctions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-sanctions--id-"></code></pre>
</div>
<form id="form-DELETEapi-sanctions--id-" data-method="DELETE" data-path="api/sanctions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-sanctions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/sanctions/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-sanctions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-sanctions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-sanctions--id-" data-component="url" required  hidden>
<br>

</p>
</form>



