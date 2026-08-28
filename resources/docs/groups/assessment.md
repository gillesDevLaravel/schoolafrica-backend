# Assessment


## Lister les assessments (Evaluations)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/assessmentsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":3,"idSection":12,"idAssessmentType":15,"idClasse":14,"idTeacher":3,"idMatter":11,"idOptionLevel":18,"is_qcm":false,"date":"2025-11-22T14:46:35+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/assessmentsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 3,
    "idSection": 12,
    "idAssessmentType": 15,
    "idClasse": 14,
    "idTeacher": 3,
    "idMatter": 11,
    "idOptionLevel": 18,
    "is_qcm": false,
    "date": "2025-11-22T14:46:35+0000"
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
    'http://localhost/api/assessmentsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 3,
            'idSection' => 12,
            'idAssessmentType' => 15,
            'idClasse' => 14,
            'idTeacher' => 3,
            'idMatter' => 11,
            'idOptionLevel' => 18,
            'is_qcm' => false,
            'date' => '2025-11-22T14:46:35+0000',
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
<div id="execution-results-POSTapi-assessmentsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-assessmentsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-assessmentsall"></code></pre>
</div>
<div id="execution-error-POSTapi-assessmentsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-assessmentsall"></code></pre>
</div>
<form id="form-POSTapi-assessmentsall" data-method="POST" data-path="api/assessmentsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-assessmentsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/assessmentsall</code></b>
</p>
<p>
<label id="auth-POSTapi-assessmentsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-assessmentsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAssessmentType</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentType" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idMatter</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idMatter" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>is_qcm</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-assessmentsall" hidden><input type="radio" name="is_qcm" value="true" data-endpoint="POSTapi-assessmentsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-assessmentsall" hidden><input type="radio" name="is_qcm" value="false" data-endpoint="POSTapi-assessmentsall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-assessmentsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## Afficher les détails d&#039;un assessment

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/assessments/esse" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessments/esse"
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
    'http://localhost/api/assessments/esse',
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
<div id="execution-results-GETapi-assessments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-assessments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-assessments--id-"></code></pre>
</div>
<div id="execution-error-GETapi-assessments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-assessments--id-"></code></pre>
</div>
<form id="form-GETapi-assessments--id-" data-method="GET" data-path="api/assessments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-assessments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/assessments/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-assessments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-assessments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-assessments--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Créer un nouvel assessment (évaluation)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/assessments" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"assessments":[{"idMatter":2,"idTeacher":12,"idClasse":13,"duration":13,"notemax":"ab","libelle":"officia","hour":{},"day":{},"oral":{},"idCoeficient":13,"orale":{},"ecrit":{},"written":{},"attitude":{},"savoir_etre":{},"pratical":{},"pratique":{},"percentage":{},"date":{},"is_qcm":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/assessments"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "assessments": [
        {
            "idMatter": 2,
            "idTeacher": 12,
            "idClasse": 13,
            "duration": 13,
            "notemax": "ab",
            "libelle": "officia",
            "hour": {},
            "day": {},
            "oral": {},
            "idCoeficient": 13,
            "orale": {},
            "ecrit": {},
            "written": {},
            "attitude": {},
            "savoir_etre": {},
            "pratical": {},
            "pratique": {},
            "percentage": {},
            "date": {},
            "is_qcm": false
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
    'http://localhost/api/assessments',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'assessments' => [
                [
                    'idMatter' => 2,
                    'idTeacher' => 12,
                    'idClasse' => 13,
                    'duration' => 13,
                    'notemax' => 'ab',
                    'libelle' => 'officia',
                    'hour' => [],
                    'day' => [],
                    'oral' => [],
                    'idCoeficient' => 13,
                    'orale' => [],
                    'ecrit' => [],
                    'written' => [],
                    'attitude' => [],
                    'savoir_etre' => [],
                    'pratical' => [],
                    'pratique' => [],
                    'percentage' => [],
                    'date' => [],
                    'is_qcm' => false,
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
<div id="execution-results-POSTapi-assessments" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-assessments"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-assessments"></code></pre>
</div>
<div id="execution-error-POSTapi-assessments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-assessments"></code></pre>
</div>
<form id="form-POSTapi-assessments" data-method="POST" data-path="api/assessments" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-assessments', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/assessments</code></b>
</p>
<p>
<label id="auth-POSTapi-assessments" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-assessments" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>assessments</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>assessments[].idMatter</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="assessments.0.idMatter" data-endpoint="POSTapi-assessments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>assessments[].idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="assessments.0.idTeacher" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="assessments.0.idClasse" data-endpoint="POSTapi-assessments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>assessments[].duration</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="assessments.0.duration" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].notemax</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="assessments.0.notemax" data-endpoint="POSTapi-assessments" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>assessments[].libelle</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.libelle" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].hour</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.hour" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].day</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.day" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].oral</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.oral" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].idCoeficient</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="assessments.0.idCoeficient" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].orale</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.orale" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].ecrit</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.ecrit" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].written</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.written" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].attitude</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.attitude" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].savoir_etre</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.savoir_etre" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].pratical</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.pratical" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].pratique</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.pratique" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].percentage</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.percentage" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="assessments.0.date" data-endpoint="POSTapi-assessments" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>assessments[].is_qcm</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-assessments" hidden><input type="radio" name="assessments.0.is_qcm" value="true" data-endpoint="POSTapi-assessments" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-assessments" hidden><input type="radio" name="assessments.0.is_qcm" value="false" data-endpoint="POSTapi-assessments" data-component="body" ><code>false</code></label>
<br>

</p>
</details>
</p>

</form>


## api/assessmentsduplicate

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/assessmentsduplicate" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"assessments_id":[7,11],"idClasse":8,"idTeacher":12,"idAssessmentTypes":[19,2],"date":"2025-11-22T14:46:35+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/assessmentsduplicate"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "assessments_id": [
        7,
        11
    ],
    "idClasse": 8,
    "idTeacher": 12,
    "idAssessmentTypes": [
        19,
        2
    ],
    "date": "2025-11-22T14:46:35+0000"
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
    'http://localhost/api/assessmentsduplicate',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'assessments_id' => [
                7,
                11,
            ],
            'idClasse' => 8,
            'idTeacher' => 12,
            'idAssessmentTypes' => [
                19,
                2,
            ],
            'date' => '2025-11-22T14:46:35+0000',
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
<div id="execution-results-POSTapi-assessmentsduplicate" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-assessmentsduplicate"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-assessmentsduplicate"></code></pre>
</div>
<div id="execution-error-POSTapi-assessmentsduplicate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-assessmentsduplicate"></code></pre>
</div>
<form id="form-POSTapi-assessmentsduplicate" data-method="POST" data-path="api/assessmentsduplicate" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-assessmentsduplicate', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/assessmentsduplicate</code></b>
</p>
<p>
<label id="auth-POSTapi-assessmentsduplicate" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-assessmentsduplicate" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>assessments_id</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="assessments_id.0" data-endpoint="POSTapi-assessmentsduplicate" data-component="body"  hidden>
<input type="number" name="assessments_id.1" data-endpoint="POSTapi-assessmentsduplicate" data-component="body" hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-assessmentsduplicate" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-assessmentsduplicate" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idAssessmentTypes</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="idAssessmentTypes.0" data-endpoint="POSTapi-assessmentsduplicate" data-component="body"  hidden>
<input type="number" name="idAssessmentTypes.1" data-endpoint="POSTapi-assessmentsduplicate" data-component="body" hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-assessmentsduplicate" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## maj des infos d&#039;un assessment

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/assessments/eum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessments/eum"
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
    'http://localhost/api/assessments/eum',
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
<div id="execution-results-PUTapi-assessments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-assessments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-assessments--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-assessments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-assessments--id-"></code></pre>
</div>
<form id="form-PUTapi-assessments--id-" data-method="PUT" data-path="api/assessments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-assessments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/assessments/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-assessments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-assessments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-assessments--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer les infos d&#039;un assessment

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/assessments/in" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessments/in"
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
    'http://localhost/api/assessments/in',
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
<div id="execution-results-DELETEapi-assessments--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-assessments--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-assessments--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-assessments--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-assessments--id-"></code></pre>
</div>
<form id="form-DELETEapi-assessments--id-" data-method="DELETE" data-path="api/assessments/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-assessments--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/assessments/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-assessments--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-assessments--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-assessments--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer plusieurs assessments

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/assessments/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/assessments/delete"
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
    'http://localhost/api/assessments/delete',
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
<div id="execution-results-POSTapi-assessments-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-assessments-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-assessments-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-assessments-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-assessments-delete"></code></pre>
</div>
<form id="form-POSTapi-assessments-delete" data-method="POST" data-path="api/assessments/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-assessments-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/assessments/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-assessments-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-assessments-delete" data-component="header"></label>
</p>
</form>



