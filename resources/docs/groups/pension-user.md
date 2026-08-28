# Pension User


## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionUsersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":16,"idSection":13,"idPension":7,"idTranche":8,"idStudent":12,"idClasse":8,"date":{},"date_start":{},"date_end":{},"payment_mode":{},"pageItems":{},"nbreItems":{},"telephone":{},"reference":{},"operator":{},"filter_value":{},"group_by":"month"}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 16,
    "idSection": 13,
    "idPension": 7,
    "idTranche": 8,
    "idStudent": 12,
    "idClasse": 8,
    "date": {},
    "date_start": {},
    "date_end": {},
    "payment_mode": {},
    "pageItems": {},
    "nbreItems": {},
    "telephone": {},
    "reference": {},
    "operator": {},
    "filter_value": {},
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
    'http://localhost/api/pensionUsersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 16,
            'idSection' => 13,
            'idPension' => 7,
            'idTranche' => 8,
            'idStudent' => 12,
            'idClasse' => 8,
            'date' => [],
            'date_start' => [],
            'date_end' => [],
            'payment_mode' => [],
            'pageItems' => [],
            'nbreItems' => [],
            'telephone' => [],
            'reference' => [],
            'operator' => [],
            'filter_value' => [],
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
<div id="execution-results-POSTapi-pensionUsersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionUsersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionUsersall"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionUsersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionUsersall"></code></pre>
</div>
<form id="form-POSTapi-pensionUsersall" data-method="POST" data-path="api/pensionUsersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionUsersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionUsersall</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionUsersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionUsersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTranche</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTranche" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pageItems" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="nbreItems" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>group_by</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="group_by" data-endpoint="POSTapi-pensionUsersall" data-component="body"  hidden>
<br>
The value must be one of <code>day</code>, <code>week</code>, or <code>month</code>.
</p>

</form>


## api/pensionUsersallarchives

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionUsersallarchives" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":11,"idSection":6,"idPension":10,"idTranche":5,"idStudent":16,"idClasse":15,"date":{},"date_start":{},"date_end":{},"payment_mode":{},"pageItems":{},"nbreItems":{},"telephone":{},"reference":{},"operator":{},"filter_value":{},"group_by":"week"}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsersallarchives"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 11,
    "idSection": 6,
    "idPension": 10,
    "idTranche": 5,
    "idStudent": 16,
    "idClasse": 15,
    "date": {},
    "date_start": {},
    "date_end": {},
    "payment_mode": {},
    "pageItems": {},
    "nbreItems": {},
    "telephone": {},
    "reference": {},
    "operator": {},
    "filter_value": {},
    "group_by": "week"
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
    'http://localhost/api/pensionUsersallarchives',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 11,
            'idSection' => 6,
            'idPension' => 10,
            'idTranche' => 5,
            'idStudent' => 16,
            'idClasse' => 15,
            'date' => [],
            'date_start' => [],
            'date_end' => [],
            'payment_mode' => [],
            'pageItems' => [],
            'nbreItems' => [],
            'telephone' => [],
            'reference' => [],
            'operator' => [],
            'filter_value' => [],
            'group_by' => 'week',
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
<div id="execution-results-POSTapi-pensionUsersallarchives" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionUsersallarchives"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionUsersallarchives"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionUsersallarchives" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionUsersallarchives"></code></pre>
</div>
<form id="form-POSTapi-pensionUsersallarchives" data-method="POST" data-path="api/pensionUsersallarchives" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionUsersallarchives', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionUsersallarchives</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionUsersallarchives" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionUsersallarchives" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTranche</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTranche" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pageItems" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="nbreItems" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>group_by</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="group_by" data-endpoint="POSTapi-pensionUsersallarchives" data-component="body"  hidden>
<br>
The value must be one of <code>day</code>, <code>week</code>, or <code>month</code>.
</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/pensionUsers/sed" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsers/sed"
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
    'http://localhost/api/pensionUsers/sed',
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
<div id="execution-results-GETapi-pensionUsers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pensionUsers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pensionUsers--id-"></code></pre>
</div>
<div id="execution-error-GETapi-pensionUsers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pensionUsers--id-"></code></pre>
</div>
<form id="form-GETapi-pensionUsers--id-" data-method="GET" data-path="api/pensionUsers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pensionUsers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pensionUsers/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-pensionUsers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-pensionUsers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-pensionUsers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Get Pdf the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/pensionuserspdf/at" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensionuserspdf/at"
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
    'http://localhost/api/pensionuserspdf/at',
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
<div id="execution-results-GETapi-pensionuserspdf--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pensionuserspdf--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pensionuserspdf--id-"></code></pre>
</div>
<div id="execution-error-GETapi-pensionuserspdf--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pensionuserspdf--id-"></code></pre>
</div>
<form id="form-GETapi-pensionuserspdf--id-" data-method="GET" data-path="api/pensionuserspdf/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pensionuserspdf--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pensionuserspdf/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-pensionuserspdf--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-pensionuserspdf--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-pensionuserspdf--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionUsers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idTransaction":10,"idStudent":16,"idPension":8,"scanReceipt":"natus","advancePayment":2,"payment_mode":"est","receiptNumber":"officia","operator":"enim","paymentDate":"autem","telephone":"est","idBourse":5}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsers"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idTransaction": 10,
    "idStudent": 16,
    "idPension": 8,
    "scanReceipt": "natus",
    "advancePayment": 2,
    "payment_mode": "est",
    "receiptNumber": "officia",
    "operator": "enim",
    "paymentDate": "autem",
    "telephone": "est",
    "idBourse": 5
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
    'http://localhost/api/pensionUsers',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idTransaction' => 10,
            'idStudent' => 16,
            'idPension' => 8,
            'scanReceipt' => 'natus',
            'advancePayment' => 2,
            'payment_mode' => 'est',
            'receiptNumber' => 'officia',
            'operator' => 'enim',
            'paymentDate' => 'autem',
            'telephone' => 'est',
            'idBourse' => 5,
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
<div id="execution-results-POSTapi-pensionUsers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionUsers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionUsers"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionUsers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionUsers"></code></pre>
</div>
<form id="form-POSTapi-pensionUsers" data-method="POST" data-path="api/pensionUsers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionUsers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionUsers</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionUsers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionUsers" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idTransaction</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTransaction" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-pensionUsers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>scanReceipt</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="scanReceipt" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>advancePayment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="advancePayment" data-endpoint="POSTapi-pensionUsers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-pensionUsers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>receiptNumber</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receiptNumber" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>paymentDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="paymentDate" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idBourse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idBourse" data-endpoint="POSTapi-pensionUsers" data-component="body"  hidden>
<br>

</p>

</form>


## api/pensionusersstorepdf

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionusersstorepdf" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idTransaction":4,"idStudent":16,"idPension":19,"scanReceipt":"sed","advancePayment":1,"payment_mode":"eligendi","receiptNumber":"accusantium","operator":"accusantium","paymentDate":"perferendis","telephone":"hic","idBourse":15}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionusersstorepdf"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idTransaction": 4,
    "idStudent": 16,
    "idPension": 19,
    "scanReceipt": "sed",
    "advancePayment": 1,
    "payment_mode": "eligendi",
    "receiptNumber": "accusantium",
    "operator": "accusantium",
    "paymentDate": "perferendis",
    "telephone": "hic",
    "idBourse": 15
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
    'http://localhost/api/pensionusersstorepdf',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idTransaction' => 4,
            'idStudent' => 16,
            'idPension' => 19,
            'scanReceipt' => 'sed',
            'advancePayment' => 1,
            'payment_mode' => 'eligendi',
            'receiptNumber' => 'accusantium',
            'operator' => 'accusantium',
            'paymentDate' => 'perferendis',
            'telephone' => 'hic',
            'idBourse' => 15,
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
<div id="execution-results-POSTapi-pensionusersstorepdf" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionusersstorepdf"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionusersstorepdf"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionusersstorepdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionusersstorepdf"></code></pre>
</div>
<form id="form-POSTapi-pensionusersstorepdf" data-method="POST" data-path="api/pensionusersstorepdf" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionusersstorepdf', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionusersstorepdf</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionusersstorepdf" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionusersstorepdf" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idTransaction</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTransaction" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>scanReceipt</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="scanReceipt" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>advancePayment</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="advancePayment" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>receiptNumber</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receiptNumber" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>paymentDate</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="paymentDate" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idBourse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idBourse" data-endpoint="POSTapi-pensionusersstorepdf" data-component="body"  hidden>
<br>

</p>

</form>


## api/balancePension

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/balancePension" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idStudent":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/balancePension"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idStudent": 11
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
    'http://localhost/api/balancePension',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idStudent' => 11,
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
<div id="execution-results-POSTapi-balancePension" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-balancePension"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-balancePension"></code></pre>
</div>
<div id="execution-error-POSTapi-balancePension" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-balancePension"></code></pre>
</div>
<form id="form-POSTapi-balancePension" data-method="POST" data-path="api/balancePension" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-balancePension', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/balancePension</code></b>
</p>
<p>
<label id="auth-POSTapi-balancePension" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-balancePension" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-balancePension" data-component="body" required  hidden>
<br>

</p>

</form>


## api/balancePensionWithBourse

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/balancePensionWithBourse" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idStudent":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/balancePensionWithBourse"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idStudent": 11
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
    'http://localhost/api/balancePensionWithBourse',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idStudent' => 11,
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
<div id="execution-results-POSTapi-balancePensionWithBourse" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-balancePensionWithBourse"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-balancePensionWithBourse"></code></pre>
</div>
<div id="execution-error-POSTapi-balancePensionWithBourse" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-balancePensionWithBourse"></code></pre>
</div>
<form id="form-POSTapi-balancePensionWithBourse" data-method="POST" data-path="api/balancePensionWithBourse" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-balancePensionWithBourse', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/balancePensionWithBourse</code></b>
</p>
<p>
<label id="auth-POSTapi-balancePensionWithBourse" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-balancePensionWithBourse" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-balancePensionWithBourse" data-component="body" required  hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/pensionUsers/eos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsers/eos"
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
    'http://localhost/api/pensionUsers/eos',
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
<div id="execution-results-DELETEapi-pensionUsers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-pensionUsers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-pensionUsers--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-pensionUsers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-pensionUsers--id-"></code></pre>
</div>
<form id="form-DELETEapi-pensionUsers--id-" data-method="DELETE" data-path="api/pensionUsers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-pensionUsers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/pensionUsers/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-pensionUsers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-pensionUsers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-pensionUsers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Archive/Restore the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionUsers/archive-restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"action":"restore","idPensionUser":7,"reason":"vero"}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsers/archive-restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "action": "restore",
    "idPensionUser": 7,
    "reason": "vero"
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
    'http://localhost/api/pensionUsers/archive-restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'action' => 'restore',
            'idPensionUser' => 7,
            'reason' => 'vero',
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
<div id="execution-results-POSTapi-pensionUsers-archive-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionUsers-archive-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionUsers-archive-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionUsers-archive-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionUsers-archive-restore"></code></pre>
</div>
<form id="form-POSTapi-pensionUsers-archive-restore" data-method="POST" data-path="api/pensionUsers/archive-restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionUsers-archive-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionUsers/archive-restore</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionUsers-archive-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionUsers-archive-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>action</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="action" data-endpoint="POSTapi-pensionUsers-archive-restore" data-component="body" required  hidden>
<br>
The value must be one of <code>archive</code> or <code>restore</code>.
</p>
<p>
<b><code>idPensionUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idPensionUser" data-endpoint="POSTapi-pensionUsers-archive-restore" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-pensionUsers-archive-restore" data-component="body"  hidden>
<br>

</p>

</form>


## Lister les insolvables de la pension/tranche

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionUsersinsolvable" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":11,"idSection":9,"nameTranche":"quae","idClasse":9,"nbreItems":1,"pageItems":12}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsersinsolvable"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 11,
    "idSection": 9,
    "nameTranche": "quae",
    "idClasse": 9,
    "nbreItems": 1,
    "pageItems": 12
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
    'http://localhost/api/pensionUsersinsolvable',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 11,
            'idSection' => 9,
            'nameTranche' => 'quae',
            'idClasse' => 9,
            'nbreItems' => 1,
            'pageItems' => 12,
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
<div id="execution-results-POSTapi-pensionUsersinsolvable" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionUsersinsolvable"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionUsersinsolvable"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionUsersinsolvable" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionUsersinsolvable"></code></pre>
</div>
<form id="form-POSTapi-pensionUsersinsolvable" data-method="POST" data-path="api/pensionUsersinsolvable" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionUsersinsolvable', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionUsersinsolvable</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionUsersinsolvable" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionUsersinsolvable" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-pensionUsersinsolvable" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-pensionUsersinsolvable" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nameTranche</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="nameTranche" data-endpoint="POSTapi-pensionUsersinsolvable" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-pensionUsersinsolvable" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-pensionUsersinsolvable" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-pensionUsersinsolvable" data-component="body"  hidden>
<br>

</p>

</form>


## Lister les solvables de la pension/tranche

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionUsersSolvable" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":2,"idSection":10,"nameTranche":"odio","idClasse":18}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionUsersSolvable"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 2,
    "idSection": 10,
    "nameTranche": "odio",
    "idClasse": 18
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
    'http://localhost/api/pensionUsersSolvable',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 2,
            'idSection' => 10,
            'nameTranche' => 'odio',
            'idClasse' => 18,
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
<div id="execution-results-POSTapi-pensionUsersSolvable" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionUsersSolvable"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionUsersSolvable"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionUsersSolvable" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionUsersSolvable"></code></pre>
</div>
<form id="form-POSTapi-pensionUsersSolvable" data-method="POST" data-path="api/pensionUsersSolvable" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionUsersSolvable', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionUsersSolvable</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionUsersSolvable" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionUsersSolvable" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-pensionUsersSolvable" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-pensionUsersSolvable" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nameTranche</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="nameTranche" data-endpoint="POSTapi-pensionUsersSolvable" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-pensionUsersSolvable" data-component="body"  hidden>
<br>

</p>

</form>


## api/pensionuserssum

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionuserssum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensionuserssum"
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
    'http://localhost/api/pensionuserssum',
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
<div id="execution-results-POSTapi-pensionuserssum" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionuserssum"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionuserssum"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionuserssum" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionuserssum"></code></pre>
</div>
<form id="form-POSTapi-pensionuserssum" data-method="POST" data-path="api/pensionuserssum" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionuserssum', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionuserssum</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionuserssum" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionuserssum" data-component="header"></label>
</p>
</form>



