<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Report card</title>
    <meta name="author" content="EGS" />
    <meta name="keywords" content="TCPDF, PDF, example, test, guide" />
    <meta name="description" content="Report card" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }
        h4 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8.5pt;
        }
        .s1 {
            color: #808080;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 4.5pt;
        }
        p {
            color: #808080;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
            margin: 0pt;
        }
        h2 {
            color: #2f8742;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 11pt;
        }
        .s2 {
            color: #808080;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }
        .s3 {
            color: #212d3d;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }
        h3 {
            color: #212d3d;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }
        .s4 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }
        .s5 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }
        .s6 {
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }
        .s7 {
            color: #212121;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }
        .s8 {
            color: #008000;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }
        h1 {
            color: #2f8742;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 13pt;
        }
        .s9 {
            color: #a52a2a;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 4.5pt;
        }
        .s10 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }
        .s11 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 7pt;
        }
        .s12 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }
        .s13 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt;
        }
        .s14 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9.5pt;
        }
        .s15 {
            color: #808080;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: bold;
            text-decoration: none;
            font-size: 6.5pt;
        }
        .s16 {
            color: #808080;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: bold;
            text-decoration: none;
            font-size: 8.5pt;
        }
        .s17 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }
        .s18 {
            color: #db0a31;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 6.5pt;
        }
        .s20 {
            color: #ff803f;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 6.5pt;
        }
        .s22 {
            color: #0080ff;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 6.5pt;
        }
        .s24 {
            color: #0080ff;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }
        .s25 {
            color: #008000;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 6.5pt;
        }
        .s27 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }
        .s28 {
            color: #0080ff;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }
        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }
    </style>
</head>
<body>


<table style="width: 100%; margin-top: 20px; font-size: 14px; text-align: center">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            <strong style="margin-bottom: 15px;">
                REPUBLIQUE DU CAMEROUN <br>
            </strong>

            <i style="font-size: 10px;">Paix-Travail-Patrie</i> <br>
            <div style="">*******</div>
            <div style="font-size: 13px">
                Ministère de l'Education de Base <br>
                Région du Centre <br>
                Département du Mfoundi
            </div>
        </td>

        <td style="width: 35%; text-align: center;">
            <img
                style="margin-top: 20pt;"
                width="201"
                height="45"
                src="data:image/png;base64,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"
            />
        </td>
        <td style="text-align: center; width: 40%;">
            <strong style="margin-bottom: 15px;">
                REPUBLIC OF CAMEROON <br>
            </strong>

            <i style="font-size: 10px;">Peace-Work-Fatherland</i> <br>
            <div style="">*******</div>
            <div style="font-size: 13px">
                Ministry of basic education <br>
                Center Region<br>
                Mfoundi Division
            </div>
        </td>
    </tr>
</table>

<h1 style="text-indent: 0pt; text-align: center;">GROUPE SCOLAIRE BILINGUE JUNIORS</h1>
<div style="text-align: center">---</div>

<hr>

<table style="width: 100%; margin-top: -5px; font-size: 14px; text-align: center">
    <tr style="width: 100%; text-align: center;">
        <td style="width: 20%"></td>
        <td style="width:100pt">
            <p style=""><span style="text-align:center; color: #fff; background-color: green; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 15pt;">Report card</span></p>
        </td>
        <td>
            <div class="textbox" style="background: #a52a2a; display: block; min-height: 15pt; top: 209pt; width: 100pt;">
                <p style="text-indent: 0pt; text-align: left;">
                    <span style="color: #fff; font-family: Arial, sans-serif; font-style: italic; font-weight: bold; text-decoration: none; font-size: 15pt;">English education </span>
                    <span style="color: #fff; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 15pt;">* annual</span>
                </p>
            </div>
        </td>
        <td>
            <p style="padding-left: 18pt; text-indent: 0pt; text-align: left;"><span style="color: #212121; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt;">2023/2024</span></p>
        </td>
        <td style="width: 20%"></td>
    </tr>
</table>

<p style="padding-left: 5pt; text-indent: 0pt; text-align: left;" />
<p style="text-indent: 0pt; text-align: left;">
            <span>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <img
                                width="64"
                                height="72"
                                src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCABIAEADASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9IqKMUYoAKMe1c9438YW/g3SPtLqJrmQ7IIM43N3J9h3/AAHevC9W+IfiHWLhpZNTngBPEVq5iRR6YU8/U5PvTSuJux9K0V80aX8QPEGk3CzRarcTY6x3LmVCPTDZ/Mc17p4G8YweM9I+0qqw3UR2Twg/dbsR3we34jnFDVgTudHRRijFIYYoxRRQB4P8atUa88WLaBm8uzhVNp6Bm+YkfUFR+FcBXWfFaRZPiBqxVgwDRrlTnkRICPwINclWq2M3uLXffBbVWsvF/wBk3N5d7C0e0Hjco3gn6BWH41wFdX8LZVi8e6SzMEBd1yTjkxsAPxJoewLc+jcUYoorI0CiiigD5l8a6Fe6H4hvlu4ZVSSeRop5F4lXOdwPQ8EZ9M81hV7r8atDfUfDcN9EpaSxk3MAf+WbYDHHfkL+Ga8JrVO5m1YWtjwnoF94g1m1hs4ZWCyoZJ41O2EZ+8x6DgH644rHr3H4I6JJp/h65v5AVa+kGwHuiZAP5s/5ChuwJXPRqKKKyNAorN1/xDY+GtPe8v5hFEOFUcs7dlUdz/8ArPFeN+JPjNq+pyPFpgGmWuSAy4aVh7seB+HI9TTSuJux6z45u47PwdrMkhAU2skY/wB5htX9SK+ZKt3urXupvuvLye6b+9NIXP61Uq0rEN3Cvpf4fXiXvgrR5YxhRAI/xT5T+qmvmirVlql5pr77S7ntX6boZCh/MUNXBOx9XUV4P4b+MmsaU6R6ht1S14B34WVR7MOv4g59RXsvh/xHYeJ7BbvT5vMj6Op4eM+jDsf09M1DVi07ngXxI8RTeIfFd4Wcm2tnaCBA2VVVOCR/vEZ/EDsK5eiitDIKKKKYBRRRQAV0nw+8Ry+G/FFnKsuy2mdYbhSflKE4yfp1/D3NFFILn//Z"
                            />
                        </td>
                    </tr>
                </table>
            </span>
</p>
<h2 style="padding-top: 4pt; padding-left: 59pt; text-indent: 0pt; text-align: left;">AHOUAMA EGONO LOUISA YONA</h2>
<p class="s3" style="padding-top: 1pt; padding-left: 58pt; text-indent: 0pt; text-align: left;">N° Reg: <b>2023BIL043 </b>Date of Birth: <b>13 October</b></p>
<h3 style="padding-left: 173pt; text-indent: 0pt; text-align: left;">2020</h3>
<p class="s4" style="padding-top: 1pt; padding-left: 58pt; text-indent: 0pt; text-align: left;">
    Sex: <b>F </b>Country:
    <span>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <img
                                width="16"
                                height="11"
                                src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCAALABADASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwDF+LPxX8dWvxe8XabaeO9e0yzTX7u3iC6tcRw28YuHUDCt8qKMcAcAcCvqD9ljxRrus+BdOfVPEN7rk41KWFrue7km81RLgYZzkqR0z27V5r8SPhR4V1Lx34lurnS/Mnn1S5lkf7RKNzNKxJwGwOT2r3H4AeFNK8PeDtOttPtfs8KXbuq+Y7YO/PVia/PeMsNisR9XeGqcqVSnfVq6Utdn1Wltn1PqeEqtKhwrXo4iPNUdeo07J6NaLmfvadr2XQ//2QAA"
                            />
                        </td>
                    </tr>
                </table>
            </span>
    <span class="s6"> </span><span class="s7">Cameroun</span>
</p>
<p class="s3" style="padding-left: 58pt; text-indent: 0pt; text-align: left;">Repeating: <span class="s8">No </span>City:</p>
<h1 style="padding-top: 4pt; padding-left: 7pt; text-indent: 0pt; text-align: left;">PS-PN-A</h1>
<h3 style="padding-top: 1pt; padding-left: 5pt; text-indent: 0pt; text-align: left;">Nursery / Bilingual</h3>
<p class="s5" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">/---</p>
<p style="text-indent: 0pt; line-height: 106%; text-align: center;">
    <a href="mailto:info@gsbjuniors.com" style="color: black; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 7pt;" target="_blank">
        Phone: (+237) 222300034 / 695953795 / 661080707 | Email:
    </a>
    <a href="http://www.gsbjuniors.com/" style="color: black; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 7pt;" target="_blank">info@gsbjuniors.com | Site web: </a>
    <span style="color: black; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 7pt;">www.gsbjuniors.com The head office : YAOUNDE - Odza - Happy</span>
</p>
<p style="text-indent: 0pt; line-height: 8pt; text-align: center;">
    <span style="color: black; font-family: Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 7pt;">Arrèté de création:</span>
</p>
<p style="text-indent: 0pt; line-height: 7pt; text-align: left;">
    <span style="color: black; font-family: Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 6pt;">Print it 30/05/2024 08:51:31 - Page1/1</span>
</p>
<p style="text-indent: 0pt; text-align: left;">
            <span>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <img
                                width="132"
                                height="38"
                                src="data:image/png;base64,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"
                            />
                        </td>
                    </tr>
                </table>
            </span>
</p>
<p class="s3" style="padding-left: 5pt; text-indent: 0pt; line-height: 109%; text-align: left;">Enrolments: 32 <span style="color: #000;">Teacher:.................................</span></p>
<p class="s9" style="padding-top: 4pt; padding-left: 5pt; text-indent: 0pt; text-align: left;">.....</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>
<table style="border-collapse: collapse; margin-left: 5.29823pt;" cellspacing="0">
    <tr style="height: 11pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s10" style="padding-left: 28pt; text-indent: 0pt; line-height: 10pt; text-align: left;">DOMAINS</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s10" style="padding-left: 5pt; padding-right: 5pt; text-indent: 0pt; line-height: 10pt; text-align: center;">ACTIVITIES</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s11" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">Term-1</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s11" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">Term-2</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s11" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">Term-3</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s12" style="padding-left: 7pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Score</p>
        </td>
        <td
            style="
                        width: 80pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s12" style="padding-left: 2pt; text-indent: 0pt; line-height: 10pt; text-align: left;">APPRECIATIONS</p>
        </td>
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s10" style="padding-left: 31pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Remarks</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
        >
            <p class="s13" style="padding-left: 24pt; padding-right: 19pt; text-indent: -4pt; line-height: 109%; text-align: left;">ARTS AND CRAFTS.</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Colouring.</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 80pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
        >
            <p style="padding-left: 21pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="47"
                                            height="47"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
        >
            <p class="s13" style="text-indent: 0pt; text-align: center;">...</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Drawing.</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Hand work.</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Music.</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Painting</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="6"
            bgcolor="#EFEFEF"
        >
            <p class="s13" style="text-indent: 0pt; line-height: 109%; text-align: left;">LITERACY AND C OMMUNICATION.</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">National language</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 80pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="6"
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="6"
            bgcolor="#EFEFEF"
        >
            <p class="s13" style="text-indent: 0pt; text-align: center;">...</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Reading</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Rhymes</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Sign Lang and Gesture</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Story Telling</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Writing</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="3"
        >
            <p class="s13" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">MOTOR SKILL.</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Athletics</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 80pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="3"
        >
            <p style="padding-left: 21pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="47"
                                            height="47"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="3"
        >
            <p class="s13" style="text-indent: 0pt; text-align: center;">...</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Gymnastics</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Physical education</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
            bgcolor="#EFEFEF"
        >
            <p class="s13" style="padding-left: 31pt; padding-right: 1pt; text-indent: -30pt; line-height: 109%; text-align: left;">PRACTICAL LIFE SKILL.</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Character Eduction</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 80pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
            bgcolor="#EFEFEF"
        >
            <p class="s13" style="text-indent: 0pt; text-align: center;">...</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Citizenship</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Environmental education</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Health education</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Safety education</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#EFEFEF"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 12pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
        >
            <p class="s13" style="padding-left: 6pt; padding-right: 4pt; text-indent: -1pt; line-height: 109%; text-align: left;">SCIENCES AND TECHNOLOGY.</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; line-height: 10pt; text-align: center;">Agriculture</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 80pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
        >
            <p style="padding-left: 22pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="47"
                                            height="47"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="5"
        >
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="22"
                                            height="65"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p class="s13" style="text-indent: 0pt; text-align: center;">...</p>
        </td>
    </tr>
    <tr style="height: 12pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="22"
                                            height="65"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="22"
                                            height="65"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="21"
                                            height="62"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; line-height: 10pt; text-align: center;">ICT</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Mathematics</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Sciences</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 24pt;">
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s14" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Sensory and perceptive</p>
            <p class="s14" style="padding-top: 1pt; padding-left: 5pt; padding-right: 5pt; text-indent: 0pt; line-height: 10pt; text-align: center;">educ</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
</table>
<p style="text-indent: 0pt; text-align: left;"><br /></p>
<table style="border-collapse: collapse; margin-left: 5.29823pt;" cellspacing="0">
    <tr style="height: 11pt;">
        <td
            style="
                        width: 100pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="7"
                                            height="7"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAcUlEQVQImU2MsQ3CQAADzy8WIekQScf+OxBREokCNqCIlP+jgACubPns8JGHkywLALmeAxAAu1HiFn+A/eDamqqtH1ut1efjbtsfW1o/tkAE8z8FSjQgG7AVda2UzNN7IHwNsLtd8r2xGyRBtcxTAXgBbrI7SI9ZPd0AAAAASUVORK5CYIIA"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p class="s15" style="text-indent: 0pt; text-align: left;">Appreciation&#39;s Legend</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s16" style="padding-left: 28pt; text-indent: 0pt; line-height: 9pt; text-align: left;">Results periods</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s17" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">Term.1</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s17" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">Term.2</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p class="s17" style="padding-left: 7pt; text-indent: 0pt; text-align: left;">Term.3</p>
        </td>
        <td style="width: 220pt;" rowspan="5">
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 13pt;">
        <td style="width: 100pt; border-left-style: solid; border-left-width: 1pt; border-left-color: #808080; border-right-style: solid; border-right-width: 1pt; border-right-color: #808080;" bgcolor="#F0F0F0">
            <p class="s18" style="padding-left: 5pt; text-indent: 0pt; line-height: 5pt; text-align: left;">[0;10[ = <b>NYE </b>= Not yet meeting</p>
            <p class="s18" style="text-indent: 0pt; line-height: 7pt; text-align: left;">expectations</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
            bgcolor="#F0F0F0"
        >
            <p class="s17" style="padding-left: 41pt; text-indent: 0pt; text-align: left;">Appreciation</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
            bgcolor="#F0F0F0"
        >
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="37"
                                            height="37"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
            bgcolor="#F0F0F0"
        >
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="37"
                                            height="37"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
            bgcolor="#F0F0F0"
        >
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="37"
                                            height="37"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAlCAYAAADFniADAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAALz0lEQVRYha2Ye7BlRXXGv29178c55z7nztx5DwMCMo7DewgIGFErI5oopRitqJVUJQZjGRMq1pBAYmkZkiqjpRiqgJLESDTEWCSYsjAqEXkE8iAiRASGGUZmcJj33Nc5Z5+9u/vLH/fegeEVkfSuXbW79+q1fntV99e72+EVFpIoygLee0CApFfqEny5HfJOace/cdMFB9dUl2kyuyDmcZIuFpGBUSEVoX2Yh7NH23v9Td3v77hp6ulDg5cL+rNBEVi56fjV6U2T13eX1hefsnqde+txZ+LMVa/W2uFlHMlWwDwwqCtsP7AH33ny+7p9+33cE+aSDjV7hu4O7957745/V0z/P1Bjk+N5eP+Jt42twUVvftUG27xiPTrIlWUFy7xA6dsofInc2ihcG62sg9KPqpO3UCHg2vtv4dd+eCuOzPWfWvZPvfN3Pbhz1yuCOnHLGRcceJP/9vGjoX3a2iVaihydbBjDLkOZlSx8gdJKeF+qsBYzaylzBb3viL5gC221U4sYaeFvH/iWbth+B5bc3/vcT7/y8B+kl8jai0Id98Fz/mJwav2xFYXHsqXUJHtsFzlGzdAyh9xytXyJzAp4c8itzZwtyXs6tuDZlpljcm0YPYY0hjmXsPWOv8HM9v6/9G547K2D/uAFB9sLQi354Gk3tU7LPzDaNgx1hLGswRJLGLeElo8oXVSLjpkz5CS85TAzOGcwDQEwEAWoUrI2wQwJOcQ26EdwzX/ehicOzB4Jf7ZtItbheWDuuQ3r3nvGr+sX7OMTbXKiTY3lgeNOGHERpy47W7//upu5YdlFfGzfP4MYgKpl6BHqQ6mHlLpaPnwy37f5H3DmunfzUO9h7Z7+AfrNDOeqaRxuDmPTxErt7M2WzYaxi5v7DtyI52Adk6mVr1m3LP3m+n2TI30ODQcsyaUxFzBqjqetOBe/ffb1R21janDt3RvgEBYcUSQpJH34wp0EMF+X8Jm7N6tX16xjpholummAg3XG+3clpAfzP37yr+65+gUzZc7Bf2j9E2MT7IwNRy7LiBGXMOojh3zAFRd+C+Qz32B0aGel9k99l7lLyCzRW8SZaz/CVWPniwvGJLF86BQ+8PStaBTZjzVmAzGQ0Iues0ODi1rb+Nnu1Gx91Pfiw/otr724NZkv77SEkSxh2AUM+4hhnzCWFSKJlCLGl47K+Vx79+/EhhXvY2EJuQ2QW4XcKrx6+aWY7R5hqzOMtSeshZSwdvQMlGiQoREJGomYEoczp86QGN+15s5nZ8oAgGbY9/ryG60yaagAhn1C2yd0TCgtqZORknTl1R/G3HRDMsOpp58Fby3lllAwqGBAwUZD5XqceOJJqMMAe3YdwFWf+l3lbkiFh0oHDlmNtmvYsYCyFVm0DNlaO2PihJUTx0Ctfu3aVa0hy0ayxI5PbFNoW0LhhZyAt0Yk+eXrb0FSgNTgwN5ZSAHeNXAW6SzCWWJV78GBfX0IQYZGX/riVxlSj4UlFoRyg0onlU5oZTU6zqGdif4XV15xDFR10ZLPL2FSKzcVLqmwiJIRJSJKi6BmKQkxHJ0aNJr6zS46NspcI2c1nA2wb/Y2zRuJBFlV0kx/BwoLKCyytIicAaUT2gpoFUSrEGY28vcWx6xZ5hAm8DZXRBZeLBlZMMG5CO8ivQt08tgzczvOOu81AHOAhPM5/+OJLXC+pkdghoAMEbsPXYWy1QCpUDRg8zmn8M5t74JjA8cEZwkFEgskFAQKi/C5MJZl+aqNx00AgC1fuTwr20XhM0NmQEbBm+ApOBMMkLdK33v4Un3lpuukSCmO4ROfPgO9/m45RBCCEXIE5rqz/OiVG2FJVCh09ee2qBoclKPkTXIUnQGegDchd1DupdwTS05bcwkA+MmzTzjzQBZdZoJHknOg5wIUEjwTjA09SnzvkfP09/caq9lpLF3yAIiGFh3ABJAQAMrwhrc/hNXrjtf48ojdM5+mYyHHRAfBG+QJOiZkBBwSMwPko/oj3AQAvjvJ852TyIhMQp4I7wCTwUFyFEgJVsOY6BjUHo+kBiIIUMSiJEEAB0IDnrRxJxuZ6uRBgGDAvLaCJsCJ8JScRA+DN2N3Kc8FAF+nMDo/cIl55/Ort45R/KOiqcXYwoKWEtB8KwTqaE9wnpPH9DxaJYkkLLpYqKszL+S0/oKlFlm0YDh9pJIEcLFZ89MKkJ69Pj0j9Mc0P8snAUohiEoU+RybhYvAAABsqJs9ogREEQ3BAEgiWBj+9D37UE0REsRkgNwzCSSFo7/kR6EXvJsioAhAcIxwMGvwqQ8d1l23BNQgGgiaVz1GgAxi1rfHAMD6/7P/jhCpGMmUiDD/HnUjnPvLK3jdx2cA5owgIxIiHCONEimJQJIESVpIqBFamItyVDJJhoJr8dPHu3zdO4aY0ALlEGRMoFKcT0pnhj8EANv5yLaZflUNUu0wgBBEBBFNMFx6eabHHqpQdccRXQOKjCJCAiIJzd8UMJ+2ec1EEhETlRQAiFGGL19zgCvWjYOtWcSUEJQQBDTJ2ERDFRN6D+3/OgBYrAPc/vDjOpj6Igbzt5KAmYHDlvcvxR/+2nZlfhQVCsREJHkEeTRyCskQZYoyRBliMjUCghJDbCGEAk3t8M2/62PrjRmaQQtBNSoYGkGDSA0C1VQK+x56chewsMws+0l5dT9EDAZEFT0GcqwF9Jnj4t8aFtjCtVfNAS5DVIaQPJrkFVQwpgyNMjbK1ChDkzxDyhHgFWNbwggue8u03nP5UjQcR1/UQE79SFTJsYrGXoxMB7Vz0K/SUajdt//41rkemkHlUQWi3wi96BEjMV03/MQ/Lud/3eX0ha0zoA0j2UApdBgT1cAQBIRkDCIa5ApKiMh4+EiG33jjYV34zg7OvcRUKaJJxiqRPRHd6NBrHPq1MHpP7x2L09EAoDfTTXwi3tD0pG5NdOHRSw696NhPDrMV8PnvjnDPUy1c9uYpbH9wnCgiKjbopxwxFIgiQshAX7HprcF1f+Lw0Uv28r2Xj+Cdv9NmNehwEOc/tpucetE0Vxu6A2FqhjNP3vfII0clZvGhPdz2/pMb6lWjGSY6A07mxIiPGvEN5n9nItpljcfvFb765/sRmwIbzyp1+nlkZzSh3wO2/cjwwN2HMX046uRNK/iRLwxQx5WoU6UqJXZDGzNROJK8jtTk/r7D4elMxTdmz3/iX3903/OgAGD5xRt/tfNLQ1/LltVYWRDjXpqwwHae1GGDliU413A4z1UdcPzBnT08eO8U9u9p4HzQccet5DlvaemUzaLyGfRCiQEcYsjUTcbp6NRtiEOp5MEeMTVX49Cj9f3T1zy8+dkcz9tijX3snHtWrEvnl+PEkoIYzRuNOrFjQW2XmFtUYRW8SyAcvUqYRSRGIEUgZYhyCClXjZr9ZKiTw1w0zUTHuWA4MshwaE74yXRTZ1c/1ulNd8NLQjnvmF+5YffqyXL10DA10k5cYglDLqDlktpGlBScq+ho8qkgXR8SBRBJxgZRMWVsElApQz9CM8E4k5yma2J6jtw/nWJxw75le3c8deS5DC+4GW2PdCxe/qon10+Ua/LRiJFMGs3BtgW0HVFaUMFET8ozUiSEBIBQoiKMgwRUyalKxq6AudphunaqZsFdfcWxm6dOeuq/t+98ofgvum3Pi5zty06/pX2SXTJagJ0W0CmE0iJaLionmFFyTHAkJUBICLL5FUFAPzn1o7FqiF5lmOsb9u7t7x25+cCGvTuemnqx2P/nqcuaLZt+Ze4N7tbR0dyGc8K3o9oGFCYUBLL5PSgkCRAbEEhOPYGhoqaV2GuEmZ6Tu7/3mamvb9taV/VLxvyZzqfKoZafuPSUT05t8lsns8xnPiIvBHOCJ2BOkAQBiImokyEEoBsSBgMq7Aj/ln3z6bcf3Ln3eePn54ZaLM47rrrgpPOaU4srBpN8W9FqmWUkqMVNDkKMiD0kTKfHh/dkf3n424/eOL3/8ODlxHnZx4uLpeyU+KO/3nrXd47cc3IV5gAAIUW8/oQL3Zc+8MXl3ale+nnPP/8XxvxAfarXF/IAAAAASUVORK5CYIIA"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
    </tr>
    <tr style="height: 17pt;">
        <td style="width: 100pt; border-left-style: solid; border-left-width: 1pt; border-left-color: #808080; border-right-style: solid; border-right-width: 1pt; border-right-color: #808080;">
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="7"
                                            height="7"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAs0lEQVQImV3NvQ7BUACG4e+c/lBJI0YGl2Dr0vQGTBKTa3APegXCZGa0iTBYkEg36VCbxdkkIhgsqs35LGLwrO/wAl9CCESj1h7/7peIfC6oVUfnG/A0aBAApFO07ErZwvlqU2RXkdf7rNoHAoCpJs0XHnPUcBR47iDVGto1hOuIMgqWaTC2qeKYaZpyG4Y6W5X073mbtfkag1ky5HvpMO5a/EUpJYIg8JJpT/u+70kpAQAfr/pIBFOnrvUAAAAASUVORK5CYIIA"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p class="s20" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">[10;15[ = <b>AE </b>= Approaching</p>
            <p class="s20" style="text-indent: 0pt; line-height: 7pt; text-align: left;">expectations</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td style="width: 100pt; border-left-style: solid; border-left-width: 1pt; border-left-color: #808080; border-right-style: solid; border-right-width: 1pt; border-right-color: #808080;" bgcolor="#F0F0F0">
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="7"
                                            height="7"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAuUlEQVQImU3OMQ7BUAAG4P89r6VptERiE4PJRFh6ADaTRFzBIZzAYDCI3UgY2YwMjmCQSBiQFEVSrd9C4jvBB3xVhk0erxsmugXiX21cJEn2FlmSZHtWJQDI3MChY3tQWhQZ80BdKQi5hdkp+TJtv2hrL0yXpBEJxGgVgaUCZFIxTV5cXTzCKO6hLvy35NOP4xYonNwgFABQnxRYts9IGsTxbmDpJjBvrIX4pfJ9h5blY+dJ7ltrCQAfCaxL0mqwkLEAAAAASUVORK5CYIIA"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p class="s22" style="padding-left: 5pt; text-indent: 0pt; line-height: 7pt; text-align: left;">[15;18[ = <b>ME </b>= Meeting</p>
            <p class="s22" style="text-indent: 0pt; line-height: 7pt; text-align: left;">expectations</p>
        </td>
        <td
            style="
                        width: 124pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
        >
            <p class="s17" style="padding-left: 5pt; text-indent: 0pt; text-align: center;">Grade</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
        >
            <p class="s24" style="text-indent: 0pt; text-align: center;">A</p>
        </td>
        <td
            style="
                        width: 40pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="2"
        >
            <p class="s24" style="text-indent: 0pt; text-align: center;">A</p>
        </td>
    </tr>
    <tr style="height: 16pt;">
        <td
            style="
                        width: 100pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
        >
            <p style="text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="7"
                                            height="7"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAi0lEQVQImY2OMQ7BYBxH3//r108aoouFzSSxd3IFo0PYXcHUg0gkNuklxOYCJgykGAxNm59NIhZvfMPLg39oxyGo7GruvD5yPDtUALvM7lqbpKN6IeoAcJ0EmTkAdBvqdCm1zFdSbvpKa+9VPweaZl7amAxA51TWf5i2Jo1a2KuGovkdqxY0aewSgDeIqzW0IU6NBQAAAABJRU5ErkJgggAA"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
            <p class="s25" style="padding-left: 5pt; text-indent: 0pt; text-align: left;">[18;20] = <b>AbE </b>= Above</p>
            <p class="s25" style="text-indent: 0pt; line-height: 7pt; text-align: left;">expectations</p>
        </td>
    </tr>
    <tr style="height: 11pt;">
        <td
            style="
                        width: 141pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
            bgcolor="#DBDBDB"
        >
            <p class="s27" style="padding-left: 35pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Summary of work</p>
        </td>
        <td
            style="
                        width: 141pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
            bgcolor="#DBDBDB"
        >
            <p class="s27" style="padding-left: 40pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Teacher&#39;s Visa</p>
        </td>
        <td
            style="
                        width: 141pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
            bgcolor="#DBDBDB"
        >
            <p class="s27" style="padding-left: 40pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Director &#39;s Visa</p>
        </td>
        <td
            style="
                        width: 141pt;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            bgcolor="#DBDBDB"
        >
            <p class="s27" style="padding-left: 44pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Parent&#39;s visa</p>
        </td>
    </tr>
    <tr style="height: 27pt;">
        <td
            style="
                        width: 141pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
        >
            <p style="padding-left: 58pt; text-indent: 0pt; text-align: left;">
                        <span>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <img
                                            width="32"
                                            height="32"
                                            src="data:image/png;base64,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"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </span>
            </p>
        </td>
        <td
            style="
                        width: 141pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
            rowspan="3"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 141pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
            rowspan="3"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
        <td
            style="
                        width: 141pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            rowspan="3"
        >
            <p style="text-indent: 0pt; text-align: left;"><br /></p>
        </td>
    </tr>
    <tr style="height: 11pt;">
        <td
            style="
                        width: 141pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
        >
            <p class="s28" style="padding-left: 27pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Meeting expectations</p>
        </td>
    </tr>
    <tr style="height: 11pt;">
        <td
            style="
                        width: 141pt;
                        border-top-style: solid;
                        border-top-width: 1pt;
                        border-top-color: #808080;
                        border-left-style: solid;
                        border-left-width: 1pt;
                        border-left-color: #808080;
                        border-bottom-style: solid;
                        border-bottom-width: 1pt;
                        border-bottom-color: #808080;
                        border-right-style: solid;
                        border-right-width: 1pt;
                        border-right-color: #808080;
                    "
            colspan="2"
        >
            <p class="s10" style="padding-left: 24pt; text-indent: 0pt; line-height: 10pt; text-align: left;">Decision: <span class="s28">PROMOTED</span></p>
        </td>
    </tr>
</table>
</body>
</html>
