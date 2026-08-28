# Establishment

Gestion des établissements scolaire

## Afficher la liste des établissements

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/establishmentsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/establishmentsall"
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
    'http://localhost/api/establishmentsall',
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
<div id="execution-results-POSTapi-establishmentsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-establishmentsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-establishmentsall"></code></pre>
</div>
<div id="execution-error-POSTapi-establishmentsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-establishmentsall"></code></pre>
</div>
<form id="form-POSTapi-establishmentsall" data-method="POST" data-path="api/establishmentsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-establishmentsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/establishmentsall</code></b>
</p>
<p>
<label id="auth-POSTapi-establishmentsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-establishmentsall" data-component="header"></label>
</p>
</form>


## Afficher les infos d&#039;un établissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/establishments/consequatur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/establishments/consequatur"
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
    'http://localhost/api/establishments/consequatur',
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
<div id="execution-results-GETapi-establishments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-establishments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-establishments--id-"></code></pre>
</div>
<div id="execution-error-GETapi-establishments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-establishments--id-"></code></pre>
</div>
<form id="form-GETapi-establishments--id-" data-method="GET" data-path="api/establishments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-establishments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/establishments/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-establishments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-establishments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-establishments--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un établissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/establishments" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"ipsam","ministry":"praesentium","region":"et","department":"cumque","phone":"quia","mobile_money_number":{},"country":"iste","email":"id","idPackage":"qui","pay_om_fees":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/establishments"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ipsam",
    "ministry": "praesentium",
    "region": "et",
    "department": "cumque",
    "phone": "quia",
    "mobile_money_number": {},
    "country": "iste",
    "email": "id",
    "idPackage": "qui",
    "pay_om_fees": false
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
    'http://localhost/api/establishments',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'ipsam',
            'ministry' => 'praesentium',
            'region' => 'et',
            'department' => 'cumque',
            'phone' => 'quia',
            'mobile_money_number' => [],
            'country' => 'iste',
            'email' => 'id',
            'idPackage' => 'qui',
            'pay_om_fees' => false,
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
<div id="execution-results-POSTapi-establishments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-establishments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-establishments"></code></pre>
</div>
<div id="execution-error-POSTapi-establishments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-establishments"></code></pre>
</div>
<form id="form-POSTapi-establishments" data-method="POST" data-path="api/establishments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-establishments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/establishments</code></b>
</p>
<p>
<label id="auth-POSTapi-establishments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-establishments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-establishments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>ministry</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="ministry" data-endpoint="POSTapi-establishments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>region</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="region" data-endpoint="POSTapi-establishments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>department</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="department" data-endpoint="POSTapi-establishments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone" data-endpoint="POSTapi-establishments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>mobile_money_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="mobile_money_number" data-endpoint="POSTapi-establishments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>country</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country" data-endpoint="POSTapi-establishments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-establishments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idPackage</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idPackage" data-endpoint="POSTapi-establishments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pay_om_fees</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-establishments" hidden><input type="radio" name="pay_om_fees" value="true" data-endpoint="POSTapi-establishments" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-establishments" hidden><input type="radio" name="pay_om_fees" value="false" data-endpoint="POSTapi-establishments" data-component="body" required ><code>false</code></label>
<br>

</p>

</form>


## maj des infos d&#039;un établissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/establishments/quasi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"officia","ministry":"ex","region":"optio","department":"sapiente","phone":"voluptatum","mobile_money_number":{},"country":"quia","email":"esse","idPackage":"et","pay_om_fees":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/establishments/quasi"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "officia",
    "ministry": "ex",
    "region": "optio",
    "department": "sapiente",
    "phone": "voluptatum",
    "mobile_money_number": {},
    "country": "quia",
    "email": "esse",
    "idPackage": "et",
    "pay_om_fees": false
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
    'http://localhost/api/establishments/quasi',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'officia',
            'ministry' => 'ex',
            'region' => 'optio',
            'department' => 'sapiente',
            'phone' => 'voluptatum',
            'mobile_money_number' => [],
            'country' => 'quia',
            'email' => 'esse',
            'idPackage' => 'et',
            'pay_om_fees' => false,
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
<div id="execution-results-PUTapi-establishments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-establishments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-establishments--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-establishments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-establishments--id-"></code></pre>
</div>
<form id="form-PUTapi-establishments--id-" data-method="PUT" data-path="api/establishments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-establishments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/establishments/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-establishments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-establishments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-establishments--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-establishments--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>ministry</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="ministry" data-endpoint="PUTapi-establishments--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>region</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="region" data-endpoint="PUTapi-establishments--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>department</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="department" data-endpoint="PUTapi-establishments--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone" data-endpoint="PUTapi-establishments--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>mobile_money_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="mobile_money_number" data-endpoint="PUTapi-establishments--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>country</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="country" data-endpoint="PUTapi-establishments--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="PUTapi-establishments--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idPackage</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idPackage" data-endpoint="PUTapi-establishments--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pay_om_fees</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="PUTapi-establishments--id-" hidden><input type="radio" name="pay_om_fees" value="true" data-endpoint="PUTapi-establishments--id-" data-component="body" required ><code>true</code></label>
<label data-endpoint="PUTapi-establishments--id-" hidden><input type="radio" name="pay_om_fees" value="false" data-endpoint="PUTapi-establishments--id-" data-component="body" required ><code>false</code></label>
<br>

</p>

</form>


## Supprimer un établissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/establishments/eos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/establishments/eos"
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
    'http://localhost/api/establishments/eos',
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
<div id="execution-results-DELETEapi-establishments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-establishments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-establishments--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-establishments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-establishments--id-"></code></pre>
</div>
<form id="form-DELETEapi-establishments--id-" data-method="DELETE" data-path="api/establishments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-establishments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/establishments/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-establishments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-establishments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-establishments--id-" data-component="url" required  hidden>
<br>

</p>
</form>



