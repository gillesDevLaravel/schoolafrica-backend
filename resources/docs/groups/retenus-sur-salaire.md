# Retenus sur salaire

Gestion des retenus sur salaires

## Lister les retenus sur salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salaries-deductionsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":3,"idUserApprove":17,"trashed":false,"date":"2025-11-22","status":"pending_approval","pageItems":14,"nbreItems":1,"filter_value":"qui"}'

```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductionsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 3,
    "idUserApprove": 17,
    "trashed": false,
    "date": "2025-11-22",
    "status": "pending_approval",
    "pageItems": 14,
    "nbreItems": 1,
    "filter_value": "qui"
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
    'http://localhost/api/salaries-deductionsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 3,
            'idUserApprove' => 17,
            'trashed' => false,
            'date' => '2025-11-22',
            'status' => 'pending_approval',
            'pageItems' => 14,
            'nbreItems' => 1,
            'filter_value' => 'qui',
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
<div id="execution-results-POSTapi-salaries-deductionsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salaries-deductionsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salaries-deductionsall"></code></pre>
</div>
<div id="execution-error-POSTapi-salaries-deductionsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salaries-deductionsall"></code></pre>
</div>
<form id="form-POSTapi-salaries-deductionsall" data-method="POST" data-path="api/salaries-deductionsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salaries-deductionsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salaries-deductionsall</code></b>
</p>
<p>
<label id="auth-POSTapi-salaries-deductionsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salaries-deductionsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-salaries-deductionsall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-salaries-deductionsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-salaries-deductionsall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-salaries-deductionsall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-salaries-deductionsall" data-component="body"  hidden>
<br>

</p>

</form>


## Ajout d&#039;une ou plusieurs retenues sur salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salaries-deductions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"salary_deductions":[{"idUser":"nihil","idUserApprove":16,"amount":1258.6,"date":"2025-11-22T14:46:50+0000","status":"in_progress","reason":"libero"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductions"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "salary_deductions": [
        {
            "idUser": "nihil",
            "idUserApprove": 16,
            "amount": 1258.6,
            "date": "2025-11-22T14:46:50+0000",
            "status": "in_progress",
            "reason": "libero"
        }
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
    'http://localhost/api/salaries-deductions',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'salary_deductions' => [
                [
                    'idUser' => 'nihil',
                    'idUserApprove' => 16,
                    'amount' => 1258.6,
                    'date' => '2025-11-22T14:46:50+0000',
                    'status' => 'in_progress',
                    'reason' => 'libero',
                ],
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
<div id="execution-results-POSTapi-salaries-deductions" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salaries-deductions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salaries-deductions"></code></pre>
</div>
<div id="execution-error-POSTapi-salaries-deductions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salaries-deductions"></code></pre>
</div>
<form id="form-POSTapi-salaries-deductions" data-method="POST" data-path="api/salaries-deductions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salaries-deductions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salaries-deductions</code></b>
</p>
<p>
<label id="auth-POSTapi-salaries-deductions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salaries-deductions" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>salary_deductions</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>salary_deductions[].idUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_deductions.0.idUser" data-endpoint="POSTapi-salaries-deductions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>salary_deductions[].idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="salary_deductions.0.idUserApprove" data-endpoint="POSTapi-salaries-deductions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>salary_deductions[].amount</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="salary_deductions.0.amount" data-endpoint="POSTapi-salaries-deductions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>salary_deductions[].date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_deductions.0.date" data-endpoint="POSTapi-salaries-deductions" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>salary_deductions[].status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="salary_deductions.0.status" data-endpoint="POSTapi-salaries-deductions" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>salary_deductions[].reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_deductions.0.reason" data-endpoint="POSTapi-salaries-deductions" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;une retenue sur salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/salaries-deductions/consectetur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductions/consectetur"
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
    'http://localhost/api/salaries-deductions/consectetur',
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
<div id="execution-results-GETapi-salaries-deductions--salary_deduction-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-salaries-deductions--salary_deduction-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-salaries-deductions--salary_deduction-"></code></pre>
</div>
<div id="execution-error-GETapi-salaries-deductions--salary_deduction-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-salaries-deductions--salary_deduction-"></code></pre>
</div>
<form id="form-GETapi-salaries-deductions--salary_deduction-" data-method="GET" data-path="api/salaries-deductions/{salary_deduction}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-salaries-deductions--salary_deduction-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/salaries-deductions/{salary_deduction}</code></b>
</p>
<p>
<label id="auth-GETapi-salaries-deductions--salary_deduction-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-salaries-deductions--salary_deduction-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>salary_deduction</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_deduction" data-endpoint="GETapi-salaries-deductions--salary_deduction-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier les détails d&#039;une retenue sur salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/salaries-deductions/doloribus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":3,"idUserApprove":18,"amount":{},"reason":"odit","date":"2025-11-22","status":"approved"}'

```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductions/doloribus"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 3,
    "idUserApprove": 18,
    "amount": {},
    "reason": "odit",
    "date": "2025-11-22",
    "status": "approved"
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
    'http://localhost/api/salaries-deductions/doloribus',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 3,
            'idUserApprove' => 18,
            'amount' => [],
            'reason' => 'odit',
            'date' => '2025-11-22',
            'status' => 'approved',
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
<div id="execution-results-PUTapi-salaries-deductions--salary_deduction-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-salaries-deductions--salary_deduction-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-salaries-deductions--salary_deduction-"></code></pre>
</div>
<div id="execution-error-PUTapi-salaries-deductions--salary_deduction-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-salaries-deductions--salary_deduction-"></code></pre>
</div>
<form id="form-PUTapi-salaries-deductions--salary_deduction-" data-method="PUT" data-path="api/salaries-deductions/{salary_deduction}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-salaries-deductions--salary_deduction-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/salaries-deductions/{salary_deduction}</code></b>
</p>
<p>
<label id="auth-PUTapi-salaries-deductions--salary_deduction-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>salary_deduction</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_deduction" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="amount" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-salaries-deductions--salary_deduction-" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>

</form>


## Archiver une ou plusieurs retenues sur salaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salaries-deductions/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSalaryDeductions":["quia",null]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductions/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSalaryDeductions": [
        "quia",
        null
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
    'http://localhost/api/salaries-deductions/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSalaryDeductions' => [
                'quia',
                null,
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
<div id="execution-results-POSTapi-salaries-deductions-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salaries-deductions-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salaries-deductions-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-salaries-deductions-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salaries-deductions-trash"></code></pre>
</div>
<form id="form-POSTapi-salaries-deductions-trash" data-method="POST" data-path="api/salaries-deductions/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salaries-deductions-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salaries-deductions/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-salaries-deductions-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salaries-deductions-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSalaryDeductions</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="idSalaryDeductions.0" data-endpoint="POSTapi-salaries-deductions-trash" data-component="body" required  hidden>
<input type="text" name="idSalaryDeductions.1" data-endpoint="POSTapi-salaries-deductions-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer un ou plusisuers retenues sur salaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salaries-deductions/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSalaryDeductions":[11,14]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductions/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSalaryDeductions": [
        11,
        14
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
    'http://localhost/api/salaries-deductions/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSalaryDeductions' => [
                11,
                14,
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
<div id="execution-results-POSTapi-salaries-deductions-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salaries-deductions-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salaries-deductions-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-salaries-deductions-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salaries-deductions-restore"></code></pre>
</div>
<form id="form-POSTapi-salaries-deductions-restore" data-method="POST" data-path="api/salaries-deductions/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salaries-deductions-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salaries-deductions/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-salaries-deductions-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salaries-deductions-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSalaryDeductions</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idSalaryDeductions.0" data-endpoint="POSTapi-salaries-deductions-restore" data-component="body" required  hidden>
<input type="number" name="idSalaryDeductions.1" data-endpoint="POSTapi-salaries-deductions-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimer une ou plusieurs retenues sur salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salaries-deductions/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSalaryDeductions":[11,5]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salaries-deductions/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSalaryDeductions": [
        11,
        5
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
    'http://localhost/api/salaries-deductions/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSalaryDeductions' => [
                11,
                5,
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
<div id="execution-results-POSTapi-salaries-deductions-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salaries-deductions-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salaries-deductions-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-salaries-deductions-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salaries-deductions-delete"></code></pre>
</div>
<form id="form-POSTapi-salaries-deductions-delete" data-method="POST" data-path="api/salaries-deductions/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salaries-deductions-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salaries-deductions/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-salaries-deductions-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salaries-deductions-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSalaryDeductions</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idSalaryDeductions.0" data-endpoint="POSTapi-salaries-deductions-delete" data-component="body" required  hidden>
<input type="number" name="idSalaryDeductions.1" data-endpoint="POSTapi-salaries-deductions-delete" data-component="body" hidden>
<br>

</p>

</form>



