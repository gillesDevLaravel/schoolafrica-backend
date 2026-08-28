# Withdrawal


## Afficher la liste des retraits

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/withdrawalsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/withdrawalsall"
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
    'http://localhost/api/withdrawalsall',
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
<div id="execution-results-POSTapi-withdrawalsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-withdrawalsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-withdrawalsall"></code></pre>
</div>
<div id="execution-error-POSTapi-withdrawalsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-withdrawalsall"></code></pre>
</div>
<form id="form-POSTapi-withdrawalsall" data-method="POST" data-path="api/withdrawalsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-withdrawalsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/withdrawalsall</code></b>
</p>
<p>
<label id="auth-POSTapi-withdrawalsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-withdrawalsall" data-component="header"></label>
</p>
</form>


## Enregistrer un nouveau retrait

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/withdrawals" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"qui","idSection":{},"montant_retrait_brut":"nostrum","montant_retrait_net":"voluptatem","frais_bancaire":{},"status":{},"mode_retrait":"aut","rib":{},"idUser":"enim","numero_retrait":{},"date":{},"created_by":{},"updated_by":{},"type":"Mobile Money"}'

```

```javascript
const url = new URL(
    "http://localhost/api/withdrawals"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "qui",
    "idSection": {},
    "montant_retrait_brut": "nostrum",
    "montant_retrait_net": "voluptatem",
    "frais_bancaire": {},
    "status": {},
    "mode_retrait": "aut",
    "rib": {},
    "idUser": "enim",
    "numero_retrait": {},
    "date": {},
    "created_by": {},
    "updated_by": {},
    "type": "Mobile Money"
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
    'http://localhost/api/withdrawals',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'qui',
            'idSection' => [],
            'montant_retrait_brut' => 'nostrum',
            'montant_retrait_net' => 'voluptatem',
            'frais_bancaire' => [],
            'status' => [],
            'mode_retrait' => 'aut',
            'rib' => [],
            'idUser' => 'enim',
            'numero_retrait' => [],
            'date' => [],
            'created_by' => [],
            'updated_by' => [],
            'type' => 'Mobile Money',
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
<div id="execution-results-POSTapi-withdrawals" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-withdrawals"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-withdrawals"></code></pre>
</div>
<div id="execution-error-POSTapi-withdrawals" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-withdrawals"></code></pre>
</div>
<form id="form-POSTapi-withdrawals" data-method="POST" data-path="api/withdrawals" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-withdrawals', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/withdrawals</code></b>
</p>
<p>
<label id="auth-POSTapi-withdrawals" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-withdrawals" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-withdrawals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>montant_retrait_brut</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="montant_retrait_brut" data-endpoint="POSTapi-withdrawals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>montant_retrait_net</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="montant_retrait_net" data-endpoint="POSTapi-withdrawals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>frais_bancaire</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="frais_bancaire" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>mode_retrait</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="mode_retrait" data-endpoint="POSTapi-withdrawals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>rib</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="rib" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idUser" data-endpoint="POSTapi-withdrawals" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>numero_retrait</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="numero_retrait" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>created_by</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="created_by" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>updated_by</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="updated_by" data-endpoint="POSTapi-withdrawals" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-withdrawals" data-component="body" required  hidden>
<br>
The value must be one of <code>Orange Money</code> or <code>Mobile Money</code>.
</p>

</form>


## api/withdrawalsconfirm

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/withdrawalsconfirm" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"code":"asperiores","idwithdrawal":"nihil"}'

```

```javascript
const url = new URL(
    "http://localhost/api/withdrawalsconfirm"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "code": "asperiores",
    "idwithdrawal": "nihil"
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
    'http://localhost/api/withdrawalsconfirm',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'code' => 'asperiores',
            'idwithdrawal' => 'nihil',
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
<div id="execution-results-POSTapi-withdrawalsconfirm" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-withdrawalsconfirm"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-withdrawalsconfirm"></code></pre>
</div>
<div id="execution-error-POSTapi-withdrawalsconfirm" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-withdrawalsconfirm"></code></pre>
</div>
<form id="form-POSTapi-withdrawalsconfirm" data-method="POST" data-path="api/withdrawalsconfirm" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-withdrawalsconfirm', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/withdrawalsconfirm</code></b>
</p>
<p>
<label id="auth-POSTapi-withdrawalsconfirm" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-withdrawalsconfirm" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="code" data-endpoint="POSTapi-withdrawalsconfirm" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idwithdrawal</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idwithdrawal" data-endpoint="POSTapi-withdrawalsconfirm" data-component="body" required  hidden>
<br>

</p>

</form>


## Afficher les informations d&#039;un retrait

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/withdrawals/accusantium" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/withdrawals/accusantium"
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
    'http://localhost/api/withdrawals/accusantium',
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
<div id="execution-results-GETapi-withdrawals--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-withdrawals--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-withdrawals--id-"></code></pre>
</div>
<div id="execution-error-GETapi-withdrawals--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-withdrawals--id-"></code></pre>
</div>
<form id="form-GETapi-withdrawals--id-" data-method="GET" data-path="api/withdrawals/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-withdrawals--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/withdrawals/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-withdrawals--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-withdrawals--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-withdrawals--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## maj des infos d&#039;un retrait

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/withdrawals/rem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/withdrawals/rem"
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
    'http://localhost/api/withdrawals/rem',
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
<div id="execution-results-PUTapi-withdrawals--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-withdrawals--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-withdrawals--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-withdrawals--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-withdrawals--id-"></code></pre>
</div>
<form id="form-PUTapi-withdrawals--id-" data-method="PUT" data-path="api/withdrawals/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-withdrawals--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/withdrawals/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-withdrawals--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-withdrawals--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-withdrawals--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un retrait

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/withdrawals/enim" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/withdrawals/enim"
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
    'http://localhost/api/withdrawals/enim',
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
<div id="execution-results-DELETEapi-withdrawals--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-withdrawals--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-withdrawals--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-withdrawals--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-withdrawals--id-"></code></pre>
</div>
<form id="form-DELETEapi-withdrawals--id-" data-method="DELETE" data-path="api/withdrawals/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-withdrawals--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/withdrawals/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-withdrawals--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-withdrawals--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-withdrawals--id-" data-component="url" required  hidden>
<br>

</p>
</form>



