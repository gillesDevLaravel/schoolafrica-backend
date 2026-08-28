# Fee User


## Listing des frais utilisateurs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feeusersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":2,"idSection":9,"idFee":3,"idStudent":1,"idClasse":1,"date":{},"date_start":{},"date_end":{},"payment_mode":{},"pageItems":5,"nbreItems":10,"filter_value":{},"telephone":{},"reference":{},"operator":{},"group_by":"month"}'

```

```javascript
const url = new URL(
    "http://localhost/api/feeusersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 2,
    "idSection": 9,
    "idFee": 3,
    "idStudent": 1,
    "idClasse": 1,
    "date": {},
    "date_start": {},
    "date_end": {},
    "payment_mode": {},
    "pageItems": 5,
    "nbreItems": 10,
    "filter_value": {},
    "telephone": {},
    "reference": {},
    "operator": {},
    "group_by": "month"
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
    'http://localhost/api/feeusersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 2,
            'idSection' => 9,
            'idFee' => 3,
            'idStudent' => 1,
            'idClasse' => 1,
            'date' => [],
            'date_start' => [],
            'date_end' => [],
            'payment_mode' => [],
            'pageItems' => 5,
            'nbreItems' => 10,
            'filter_value' => [],
            'telephone' => [],
            'reference' => [],
            'operator' => [],
            'group_by' => 'month',
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
<div id="execution-results-POSTapi-feeusersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feeusersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feeusersall"></code></pre>
</div>
<div id="execution-error-POSTapi-feeusersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feeusersall"></code></pre>
</div>
<form id="form-POSTapi-feeusersall" data-method="POST" data-path="api/feeusersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feeusersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feeusersall</code></b>
</p>
<p>
<label id="auth-POSTapi-feeusersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feeusersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>group_by</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="group_by" data-endpoint="POSTapi-feeusersall" data-component="body"  hidden>
<br>
The value must be one of <code>day</code>, <code>week</code>, or <code>month</code>.
</p>

</form>


## Listing des frais utilisateurs

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feeusersallarchives" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":13,"idSection":5,"idFee":18,"idStudent":7,"idClasse":18,"date":{},"date_start":{},"date_end":{},"payment_mode":{},"pageItems":16,"nbreItems":15,"filter_value":{},"telephone":{},"reference":{},"operator":{},"group_by":"day"}'

```

```javascript
const url = new URL(
    "http://localhost/api/feeusersallarchives"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 13,
    "idSection": 5,
    "idFee": 18,
    "idStudent": 7,
    "idClasse": 18,
    "date": {},
    "date_start": {},
    "date_end": {},
    "payment_mode": {},
    "pageItems": 16,
    "nbreItems": 15,
    "filter_value": {},
    "telephone": {},
    "reference": {},
    "operator": {},
    "group_by": "day"
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
    'http://localhost/api/feeusersallarchives',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 13,
            'idSection' => 5,
            'idFee' => 18,
            'idStudent' => 7,
            'idClasse' => 18,
            'date' => [],
            'date_start' => [],
            'date_end' => [],
            'payment_mode' => [],
            'pageItems' => 16,
            'nbreItems' => 15,
            'filter_value' => [],
            'telephone' => [],
            'reference' => [],
            'operator' => [],
            'group_by' => 'day',
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
<div id="execution-results-POSTapi-feeusersallarchives" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feeusersallarchives"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feeusersallarchives"></code></pre>
</div>
<div id="execution-error-POSTapi-feeusersallarchives" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feeusersallarchives"></code></pre>
</div>
<form id="form-POSTapi-feeusersallarchives" data-method="POST" data-path="api/feeusersallarchives" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feeusersallarchives', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feeusersallarchives</code></b>
</p>
<p>
<label id="auth-POSTapi-feeusersallarchives" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feeusersallarchives" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>group_by</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="group_by" data-endpoint="POSTapi-feeusersallarchives" data-component="body"  hidden>
<br>
The value must be one of <code>day</code>, <code>week</code>, or <code>month</code>.
</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/feeusers/ab" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/feeusers/ab"
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
    'http://localhost/api/feeusers/ab',
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
<div id="execution-results-GETapi-feeusers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-feeusers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-feeusers--id-"></code></pre>
</div>
<div id="execution-error-GETapi-feeusers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-feeusers--id-"></code></pre>
</div>
<form id="form-GETapi-feeusers--id-" data-method="GET" data-path="api/feeusers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-feeusers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/feeusers/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-feeusers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-feeusers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-feeusers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Get Pdf the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/feeuserspdf/autem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/feeuserspdf/autem"
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
    'http://localhost/api/feeuserspdf/autem',
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
<div id="execution-results-GETapi-feeuserspdf--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-feeuserspdf--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-feeuserspdf--id-"></code></pre>
</div>
<div id="execution-error-GETapi-feeuserspdf--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-feeuserspdf--id-"></code></pre>
</div>
<form id="form-GETapi-feeuserspdf--id-" data-method="GET" data-path="api/feeuserspdf/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-feeuserspdf--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/feeuserspdf/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-feeuserspdf--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-feeuserspdf--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-feeuserspdf--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feeusers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"advancePayment":"autem","idTransaction":4,"idStudent":2,"payment_mode":"ab","idFee":17,"scanReceipt":"voluptatem","receiptNumber":"accusantium","operator":"rem","paymentDate":"dolores","telephone":"beatae"}'

```

```javascript
const url = new URL(
    "http://localhost/api/feeusers"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "advancePayment": "autem",
    "idTransaction": 4,
    "idStudent": 2,
    "payment_mode": "ab",
    "idFee": 17,
    "scanReceipt": "voluptatem",
    "receiptNumber": "accusantium",
    "operator": "rem",
    "paymentDate": "dolores",
    "telephone": "beatae"
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
    'http://localhost/api/feeusers',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'advancePayment' => 'autem',
            'idTransaction' => 4,
            'idStudent' => 2,
            'payment_mode' => 'ab',
            'idFee' => 17,
            'scanReceipt' => 'voluptatem',
            'receiptNumber' => 'accusantium',
            'operator' => 'rem',
            'paymentDate' => 'dolores',
            'telephone' => 'beatae',
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
<div id="execution-results-POSTapi-feeusers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feeusers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feeusers"></code></pre>
</div>
<div id="execution-error-POSTapi-feeusers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feeusers"></code></pre>
</div>
<form id="form-POSTapi-feeusers" data-method="POST" data-path="api/feeusers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feeusers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feeusers</code></b>
</p>
<p>
<label id="auth-POSTapi-feeusers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feeusers" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>advancePayment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="advancePayment" data-endpoint="POSTapi-feeusers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTransaction</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTransaction" data-endpoint="POSTapi-feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-feeusers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-feeusers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-feeusers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scanReceipt</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="scanReceipt" data-endpoint="POSTapi-feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>receiptNumber</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receiptNumber" data-endpoint="POSTapi-feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>paymentDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="paymentDate" data-endpoint="POSTapi-feeusers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-feeusers" data-component="body"  hidden>
<br>

</p>

</form>


## Restore the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feeusers/archive-restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"action":"archive","idFeeUser":10,"reason":"nulla"}'

```

```javascript
const url = new URL(
    "http://localhost/api/feeusers/archive-restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "action": "archive",
    "idFeeUser": 10,
    "reason": "nulla"
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
    'http://localhost/api/feeusers/archive-restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'action' => 'archive',
            'idFeeUser' => 10,
            'reason' => 'nulla',
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
<div id="execution-results-POSTapi-feeusers-archive-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feeusers-archive-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feeusers-archive-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-feeusers-archive-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feeusers-archive-restore"></code></pre>
</div>
<form id="form-POSTapi-feeusers-archive-restore" data-method="POST" data-path="api/feeusers/archive-restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feeusers-archive-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feeusers/archive-restore</code></b>
</p>
<p>
<label id="auth-POSTapi-feeusers-archive-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feeusers-archive-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>action</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="action" data-endpoint="POSTapi-feeusers-archive-restore" data-component="body" required  hidden>
<br>
The value must be one of <code>archive</code> or <code>restore</code>.
</p>
<p>
<b><code>idFeeUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idFeeUser" data-endpoint="POSTapi-feeusers-archive-restore" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-feeusers-archive-restore" data-component="body"  hidden>
<br>

</p>

</form>


## api/feeusersstorepdf

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feeusersstorepdf" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"advancePayment":"cumque","idTransaction":16,"idStudent":4,"payment_mode":"laborum","idFee":17,"scanReceipt":"ad","receiptNumber":"excepturi","operator":"aut","paymentDate":"exercitationem","telephone":"quisquam"}'

```

```javascript
const url = new URL(
    "http://localhost/api/feeusersstorepdf"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "advancePayment": "cumque",
    "idTransaction": 16,
    "idStudent": 4,
    "payment_mode": "laborum",
    "idFee": 17,
    "scanReceipt": "ad",
    "receiptNumber": "excepturi",
    "operator": "aut",
    "paymentDate": "exercitationem",
    "telephone": "quisquam"
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
    'http://localhost/api/feeusersstorepdf',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'advancePayment' => 'cumque',
            'idTransaction' => 16,
            'idStudent' => 4,
            'payment_mode' => 'laborum',
            'idFee' => 17,
            'scanReceipt' => 'ad',
            'receiptNumber' => 'excepturi',
            'operator' => 'aut',
            'paymentDate' => 'exercitationem',
            'telephone' => 'quisquam',
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
<div id="execution-results-POSTapi-feeusersstorepdf" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feeusersstorepdf"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feeusersstorepdf"></code></pre>
</div>
<div id="execution-error-POSTapi-feeusersstorepdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feeusersstorepdf"></code></pre>
</div>
<form id="form-POSTapi-feeusersstorepdf" data-method="POST" data-path="api/feeusersstorepdf" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feeusersstorepdf', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feeusersstorepdf</code></b>
</p>
<p>
<label id="auth-POSTapi-feeusersstorepdf" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feeusersstorepdf" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>advancePayment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="advancePayment" data-endpoint="POSTapi-feeusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTransaction</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTransaction" data-endpoint="POSTapi-feeusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-feeusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-feeusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-feeusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scanReceipt</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="scanReceipt" data-endpoint="POSTapi-feeusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>receiptNumber</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receiptNumber" data-endpoint="POSTapi-feeusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-feeusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>paymentDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="paymentDate" data-endpoint="POSTapi-feeusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-feeusersstorepdf" data-component="body"  hidden>
<br>

</p>

</form>


## api/balancefee

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/balancefee" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/balancefee"
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
    'http://localhost/api/balancefee',
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
<div id="execution-results-POSTapi-balancefee" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-balancefee"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-balancefee"></code></pre>
</div>
<div id="execution-error-POSTapi-balancefee" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-balancefee"></code></pre>
</div>
<form id="form-POSTapi-balancefee" data-method="POST" data-path="api/balancefee" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-balancefee', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/balancefee</code></b>
</p>
<p>
<label id="auth-POSTapi-balancefee" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-balancefee" data-component="header"></label>
</p>
</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/feeusers/accusamus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/feeusers/accusamus"
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
    'http://localhost/api/feeusers/accusamus',
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
<div id="execution-results-DELETEapi-feeusers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-feeusers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-feeusers--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-feeusers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-feeusers--id-"></code></pre>
</div>
<form id="form-DELETEapi-feeusers--id-" data-method="DELETE" data-path="api/feeusers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-feeusers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/feeusers/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-feeusers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-feeusers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-feeusers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Lister les solvables/insolvables d&#039;un frais annexe

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feeusers-animi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":"aut","idFee":"voluptates","idSection":{},"idLevel":{},"idClasse":{},"idStudent":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/feeusers-animi"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": "aut",
    "idFee": "voluptates",
    "idSection": {},
    "idLevel": {},
    "idClasse": {},
    "idStudent": {}
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
    'http://localhost/api/feeusers-animi',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 'aut',
            'idFee' => 'voluptates',
            'idSection' => [],
            'idLevel' => [],
            'idClasse' => [],
            'idStudent' => [],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (404):

```json
{
    "message": "",
    "exception": "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException",
    "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/AbstractRouteCollection.php",
    "line": 43,
    "trace": [
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/RouteCollection.php",
            "line": 162,
            "function": "handleMatchedRoute",
            "class": "Illuminate\\Routing\\AbstractRouteCollection",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 639,
            "function": "match",
            "class": "Illuminate\\Routing\\RouteCollection",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 628,
            "function": "findRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 617,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 165,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 128,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 21,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 63,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fruitcake\/laravel-cors\/src\/HandleCors.php",
            "line": 52,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fruitcake\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 167,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 103,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 140,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 109,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 324,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 305,
            "function": "callLaravelOrLumenRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 76,
            "function": "makeApiCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 51,
            "function": "makeResponseCall",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Strategies\/Responses\/ResponseCalls.php",
            "line": 41,
            "function": "makeResponseCallIfEnabledAndNoSuccessResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 236,
            "function": "__invoke",
            "class": "Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 172,
            "function": "iterateThroughStrategies",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Extracting\/Generator.php",
            "line": 127,
            "function": "fetchResponses",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 119,
            "function": "processRoute",
            "class": "Knuckles\\Scribe\\Extracting\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/knuckleswtf\/scribe\/src\/Commands\/GenerateDocumentation.php",
            "line": 73,
            "function": "processRoutes",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 36,
            "function": "handle",
            "class": "Knuckles\\Scribe\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Util.php",
            "line": 37,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 93,
            "function": "unwrapIfClosure",
            "class": "Illuminate\\Container\\Util",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 37,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 596,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 134,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 298,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 121,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 1040,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 301,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/symfony\/console\/Application.php",
            "line": 171,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 93,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 129,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/mh-ibrah\/PhpstormProjects\/api_msschool_v7\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```
<div id="execution-results-POSTapi-feeusers--type-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feeusers--type-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feeusers--type-"></code></pre>
</div>
<div id="execution-error-POSTapi-feeusers--type-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feeusers--type-"></code></pre>
</div>
<form id="form-POSTapi-feeusers--type-" data-method="POST" data-path="api/feeusers-{type}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feeusers--type-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feeusers-{type}</code></b>
</p>
<p>
<label id="auth-POSTapi-feeusers--type-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feeusers--type-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-feeusers--type-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-feeusers--type-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idFee" data-endpoint="POSTapi-feeusers--type-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-feeusers--type-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idLevel" data-endpoint="POSTapi-feeusers--type-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idClasse" data-endpoint="POSTapi-feeusers--type-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idStudent" data-endpoint="POSTapi-feeusers--type-" data-component="body"  hidden>
<br>

</p>

</form>



