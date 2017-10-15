@extends('frontend.layout.master')

@section('content')		

	<div class="content">
		<h2><span>API</span></h2>
	</div>
	<div class="breadcrumb">
		<h4>Naudojimo instrukcija</h4>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="boxs">						
				
				<p>Norėdami naudotis API, visų pirma turite susikurti paskyrą šiame puslapyje. </p>
				
<!-- AUTENTIFIKAVIMAS -->
				<div class="breadcrumb">
					<h4>Autentifikavimas</h4>
				</div>					
				
				<p>Norėdami vykdyti visas API užklausas, jums reikalingas autentifikacijos raktas. Jį galite gauti, siųsdami POST užklausą adresu: <code>http://surveyapi.tk/api/surveys/login</code></p>
				
				<p><strong>Body turinys:</strong></p>
				<ul>
					<li>email : jūsų elektroninio pašto adresas, kuriuo registravotės į sistemą.</li>
					<li>password : slaptažodis, kuriuo jungiatės į sistemą.</li>
				</ul>			

				<p><strong>Grąžinamas turinys:</strong></p>
				<ul>
					<li><code><pre>
{
	"token": "1df4d0625cc60cbb9eb13a7dcbb0cb092ad1443ab47cfe1c1274ad4dd7c4b05418c42494e172d82c"
}
					</pre></code></li>
				</ul>

				<p>Šį kodą naudosime kitose užklausose.</p>
				
<!-- APKLAUSU GAVIMAS -->				
				<div class="breadcrumb">
					<h4>Apklausų gavimas</h4>
				</div>					
				
				<p>Norėdami gauti apklausas, siųskite GET užklausą adresu: <code>http://surveyapi.tk/api/surveys</code></p>
				
				<p><strong>Reikalingos antraštės:</strong></p>
				<ul>
					<li>AuthenticationToken : kodas, gautas prisijungimo užklausos rezultate.</li>
					<li>author : true, jeigu norite gauti tik savo kurtas apklausas.</li>
				</ul>		

				<p><strong>Grąžinamas turinys:</strong></p>
				<ul>
					<li><code><pre>
[
    {
        "id": 2,
        "title": "Lietuvos krepšinis",
        "description": "Apklausa apie Lietuvos krepšinį",
        "icon": "fa-laptop",
        "user_id": 1,
        "created_at": "2017-10-01 17:12:26",
        "updated_at": "2017-10-01 17:12:26"
    },
    {
        "id": 3,
        "title": "Lietuvos universitetai",
        "description": "Apklausa apie Lietuvos universitetus",
        "icon": "fa-laptop",
        "user_id": 2,
        "created_at": "2017-10-01 17:15:08",
        "updated_at": "2017-10-01 17:15:08"
    }
]
					</pre></code></li>
				</ul>

				<p>Grąžinamos visos apklausos. O jeigu nurodoma <strong>author</strong> antraštė, tada gaunamos tik jūsų kurtos apklausos. Šiuo atveju grąžinami ne tik pagrindiniai apklausos duomenys, bet ir ją sudarantys klausimai</p>
				
<code><pre>
[
    {
        "id": 2,
        "title": "Lietuvos krepšinis",
        "description": "Apklausa apie Lietuvos krepšinį",
        "icon": "fa-laptop",
        "user_id": 1,
        "created_at": "2017-10-01 17:12:26",
        "updated_at": "2017-10-01 17:12:26",
        "questions": [
            {
                "id": 2,
                "question": "Mėgstamiausia Lietuvos komanda?",
                "option1": "Žalgiris",
                "option2": "Neptūnas",
                "option3": "Lietuvos Rytas",
                "option4": "Lietkabelis",
                "survey_id": 2,
                "created_at": "2017-10-01 17:12:26",
                "updated_at": "2017-10-01 17:12:26"
            },
            {
                "id": 3,
                "question": "Mėgstamiausias krepšininkas?",
                "option1": "Jonas Valančiūnas",
                "option2": "Mindaugas Kuzminskas",
                "option3": "Domantas Sabonis",
                "option4": "Donatas Motiejūnas",
                "survey_id": 2,
                "created_at": "2017-10-01 17:12:26",
                "updated_at": "2017-10-01 17:12:26"
            }
        ]
    }
]
</pre></code>	

<!-- APKLAUSOS GAVIMAS -->		
				<div class="breadcrumb">
					<h4>Tam tikros apklausos gavimas</h4>
				</div>					
				
				<p>Norėdami gauti tam tikrą vieną apklausą, siųskite GET užklausą adresu: <code>http://surveyapi.tk/api/surveys/{id}</code></p>
			
				<p><strong>Reikalingos antraštės:</strong></p>
				<ul>
					<li>AuthenticationToken : kodas, gautas prisijungimo užklausos rezultate.</li>
				</ul>		

				<p><strong>Grąžinamas turinys:</strong></p>
				<ul>
					<li><code><pre>
{
    "id": 2,
    "title": "Lietuvos krepšinis",
    "description": "Apklausa apie Lietuvos krepšinį",
    "icon": "fa-laptop",
    "user_id": 1,
    "created_at": "2017-10-01 17:12:26",
    "updated_at": "2017-10-01 17:12:26",
    "questions": [
        {
            "id": 2,
            "question": "Mėgstamiausia Lietuvos komanda?",
            "option1": "Žalgiris",
            "option2": "Neptūnas",
            "option3": "Lietuvos Rytas",
            "option4": "Lietkabelis",
            "survey_id": 2,
            "created_at": "2017-10-01 17:12:26",
            "updated_at": "2017-10-01 17:12:26",
            "answers": []
        },
        {
            "id": 3,
            "question": "Mėgstamiausias krepšininkas?",
            "option1": "Jonas Valančiūnas",
            "option2": "Mindaugas Kuzminskas",
            "option3": "Domantas Sabonis",
            "option4": "Donatas Motiejūnas",
            "survey_id": 2,
            "created_at": "2017-10-01 17:12:26",
            "updated_at": "2017-10-01 17:12:26",
            "answers": []
        }
    ]
}
					</pre></code></li>
				</ul>	
				
				<p>Šiuo atveju gauta informacija ne tik apie apklausą, bet ir jos klausimai, bei visi atsakymai į juos</p>
				
<!-- APKLAUSOS KURIMAS -->		
				<div class="breadcrumb">
					<h4>Apklausos kūrimas</h4>
				</div>					
				
				<p>Norėdami pridėti naują apklausą, siųskite POST užklausą adresu: <code>http://surveyapi.tk/api/surveys</code></p>
			
				<p><strong>Reikalingos antraštės:</strong></p>
				<ul>
					<li>AuthenticationToken : kodas, gautas prisijungimo užklausos rezultate.</li>
				</ul>
				
				<p><strong>Body turinys:</strong></p>
<code><pre>
{
    "title": "Testuojama apklausa",
    "description": "Testuojamos apklausos aprašymas",
    "icon": "fa-laptop",
	"question_-100_title": "Klausimas",
	"question_-100_option_1": "Opcija 1",
	"question_-100_option_2": "Opcija 2",
	"question_-100_option_3": "Opcija 3",
	"question_-100_option_4": "Opcija 4",
}
</pre></code>

				<p>Tai pagrindiniai laukai kuriuos reikia nurodyti. Jeigu nurima nurodyti daugiau klausimų, tiesiog pildomi tie patys laukai tik pakeičiant -100 į -99 ir t.t didėjant</p>

				<p><strong>Grąžinamas turinys:</strong></p>
<code><pre>
{
    "success": true
}
</pre></code>				
				
				<p>Sėkmės atveju gaunamas toks pranešimas. Jeigu iškart po šios užklausos vėl patikrintume vartotojo sukurtas apklausas, matytume, jog apklausa atsirado sąraše:</p>
				
<code><pre>
[
    {
        "id": 2,
        "title": "Lietuvos krepšinis",
        "description": "Apklausa apie Lietuvos krepšinį",
        "icon": "fa-laptop",
        "user_id": 1,
        "created_at": "2017-10-01 17:12:26",
        "updated_at": "2017-10-01 17:12:26",
        "questions": [
            {
                "id": 2,
                "question": "Mėgstamiausia Lietuvos komanda?",
                "option1": "Žalgiris",
                "option2": "Neptūnas",
                "option3": "Lietuvos Rytas",
                "option4": "Lietkabelis",
                "survey_id": 2,
                "created_at": "2017-10-01 17:12:26",
                "updated_at": "2017-10-01 17:12:26"
            },
            {
                "id": 3,
                "question": "Mėgstamiausias krepšininkas?",
                "option1": "Jonas Valančiūnas",
                "option2": "Mindaugas Kuzminskas",
                "option3": "Domantas Sabonis",
                "option4": "Donatas Motiejūnas",
                "survey_id": 2,
                "created_at": "2017-10-01 17:12:26",
                "updated_at": "2017-10-01 17:12:26"
            }
        ]
    },
    {
        "id": 4,
        "title": "Testuojama apklausa",
        "description": "Testuojamos apklausos aprašymas",
        "icon": "fa-laptop",
        "user_id": 1,
        "created_at": "2017-10-01 17:36:43",
        "updated_at": "2017-10-01 17:36:43",
        "questions": [
            {
                "id": 6,
                "question": "Klausimas",
                "option1": "Opcija 1",
                "option2": "Opcija 2",
                "option3": "Opcija 3",
                "option4": "Opcija 4",
                "survey_id": 4,
                "created_at": "2017-10-01 17:36:43",
                "updated_at": "2017-10-01 17:36:43"
            }
        ]
    }
]
</pre></code>	

<!-- APKLAUSOS ŠALINIMAS -->		
				<div class="breadcrumb">
					<h4>Apklausos šalinimas</h4>
				</div>					
				
				<p>Norėdami šalinti apklausą, siųskite DELETE užklausą adresu: <code>http://surveyapi.tk/api/surveys/{id}</code></p>
			
				<p><strong>Reikalingos antraštės:</strong></p>
				<ul>
					<li>AuthenticationToken : kodas, gautas prisijungimo užklausos rezultate.</li>
				</ul>
				
				<p><strong>Grąžinamas turinys:</strong></p><code><pre>
{
    "success": true
}
</pre></code></li>					
				
				<p>Sėkmės atveju gaunamas toks pranešimas.</p>
				
<!-- APKLAUSOS REDAGAVIMAS -->		
				<div class="breadcrumb">
					<h4>Apklausos redagavimas</h4>
				</div>					
				
				<p>Norėdami redaguoti apklausą, siųskite PUT užklausą adresu: <code>http://surveyapi.tk/api/surveys/{id}</code></p>
			
				<p><strong>Reikalingos antraštės:</strong></p>
				<ul>
					<li>AuthenticationToken : kodas, gautas prisijungimo užklausos rezultate.</li>
				</ul>
				
				<p><strong>Body turinys:</strong></p>
				<ul>
					<li>
<code><pre>
{
	"title": "Lietuvos krepšinis",
	"description": "Apklausa apie Lietuvos krepšinį",
	"icon": "fa-laptop"
}
</pre></code>					
					</li>
				</ul>				
				
				<p><strong>Grąžinamas turinys:</strong></p><code><pre>
{
    "success": true
}
</pre></code></li>					
				
				<p>Sėkmės atveju gaunamas toks pranešimas. Būtina nurodyti tik šiuos tris laukus. Kiti laukai neturi reikšmės, nes redaguoti jau sukurtų klausimų negalima.</p>				
				
<!-- ATSAKYMAS Į APKLAUSĄ -->		
				<div class="breadcrumb">
					<h4>Atsakymas į apklausą</h4>
				</div>					
				
				<p>Norėdami atsakyti į apklausą, siųskite POST užklausą adresu: <code>http://surveyapi.tk/api/surveys/{id}/answer</code></p>
			
				<p><strong>Reikalingos antraštės:</strong></p>
				<ul>
					<li>AuthenticationToken : kodas, gautas prisijungimo užklausos rezultate.</li>
				</ul>
				
				<p><strong>Body turinys:</strong></p>
				<ul>
					<li>
<code><pre>
{
	"answer_13": 1
}
</pre></code>					
					</li>
				</ul>

				<p>Būtina nusiųsti atsakymą į kiekvieną klausimą. Šiuo atveju klausimo ID nurodomas po _ simbolio. Reikšmė - 1/2/3/4 priklausomai nuo to, kurį variantą norima pasirinkti</p>
				
				<p><strong>Grąžinamas turinys:</strong></p><code><pre>
{
    "success": true
}
</pre></code></li>					
				
				<p>Sėkmės atveju gaunamas toks pranešimas.</p>				
				
				
				<div class="breadcrumb">
					<h4>Klaidų pranešimai</h4>
				</div>			

				<p>Klaidų pranešimus galima pasiekti naudojant "error"  raktą.</p>
				
			</div>
		</div>
	</div>
@endsection	