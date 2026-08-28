# OrangeMoney


## api/om/callback

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/om/callback" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/om/callback"
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
    'http://localhost/api/om/callback',
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


> Example response (500):

```json
{
    "success": false,
    "message": "Une erreur s'est produite. Veuillez contacter votre administrateur.",
    "message_error": "Class 'App\\Http\\Controllers\\DB' not found"
}
```
<div id="execution-results-POSTapi-om-callback" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-om-callback"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-om-callback"></code></pre>
</div>
<div id="execution-error-POSTapi-om-callback" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-om-callback"></code></pre>
</div>
<form id="form-POSTapi-om-callback" data-method="POST" data-path="api/om/callback" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-om-callback', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/om/callback</code></b>
</p>
<p>
<label id="auth-POSTapi-om-callback" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-om-callback" data-component="header"></label>
</p>
</form>


## api/makewebpayment

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/makewebpayment" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":8,"idSection":16,"idFee":13,"idLevel":4,"idStudent":15,"amount":"et","payment_mode":"fuga","idPension":5}'

```

```javascript
const url = new URL(
    "http://localhost/api/makewebpayment"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 8,
    "idSection": 16,
    "idFee": 13,
    "idLevel": 4,
    "idStudent": 15,
    "amount": "et",
    "payment_mode": "fuga",
    "idPension": 5
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
    'http://localhost/api/makewebpayment',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 8,
            'idSection' => 16,
            'idFee' => 13,
            'idLevel' => 4,
            'idStudent' => 15,
            'amount' => 'et',
            'payment_mode' => 'fuga',
            'idPension' => 5,
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
<div id="execution-results-POSTapi-makewebpayment" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-makewebpayment"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-makewebpayment"></code></pre>
</div>
<div id="execution-error-POSTapi-makewebpayment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-makewebpayment"></code></pre>
</div>
<form id="form-POSTapi-makewebpayment" data-method="POST" data-path="api/makewebpayment" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-makewebpayment', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/makewebpayment</code></b>
</p>
<p>
<label id="auth-POSTapi-makewebpayment" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-makewebpayment" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-makewebpayment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-makewebpayment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-makewebpayment" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-makewebpayment" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-makewebpayment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="amount" data-endpoint="POSTapi-makewebpayment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-makewebpayment" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-makewebpayment" data-component="body"  hidden>
<br>

</p>

</form>


## api/getstatuspayment/{id}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/getstatuspayment/non" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/getstatuspayment/non"
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
    'http://localhost/api/getstatuspayment/non',
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
<div id="execution-results-GETapi-getstatuspayment--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-getstatuspayment--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-getstatuspayment--id-"></code></pre>
</div>
<div id="execution-error-GETapi-getstatuspayment--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-getstatuspayment--id-"></code></pre>
</div>
<form id="form-GETapi-getstatuspayment--id-" data-method="GET" data-path="api/getstatuspayment/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-getstatuspayment--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/getstatuspayment/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-getstatuspayment--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-getstatuspayment--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-getstatuspayment--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## api/makemobpayment

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/makemobpayment" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/makemobpayment"
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
    'http://localhost/api/makemobpayment',
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
<div id="execution-results-POSTapi-makemobpayment" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-makemobpayment"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-makemobpayment"></code></pre>
</div>
<div id="execution-error-POSTapi-makemobpayment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-makemobpayment"></code></pre>
</div>
<form id="form-POSTapi-makemobpayment" data-method="POST" data-path="api/makemobpayment" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-makemobpayment', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/makemobpayment</code></b>
</p>
<p>
<label id="auth-POSTapi-makemobpayment" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-makemobpayment" data-component="header"></label>
</p>
</form>


## api/getstatuspaymentmob/{id}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/getstatuspaymentmob/dolorum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/getstatuspaymentmob/dolorum"
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
    'http://localhost/api/getstatuspaymentmob/dolorum',
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
<div id="execution-results-GETapi-getstatuspaymentmob--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-getstatuspaymentmob--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-getstatuspaymentmob--id-"></code></pre>
</div>
<div id="execution-error-GETapi-getstatuspaymentmob--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-getstatuspaymentmob--id-"></code></pre>
</div>
<form id="form-GETapi-getstatuspaymentmob--id-" data-method="GET" data-path="api/getstatuspaymentmob/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-getstatuspaymentmob--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/getstatuspaymentmob/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-getstatuspaymentmob--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-getstatuspaymentmob--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-getstatuspaymentmob--id-" data-component="url" required  hidden>
<br>

</p>
</form>



