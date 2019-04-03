<?php 
    $companies = [
        [
            "url" => "http://www.premiumams.com/",
            "img" => "/img/company-premium-ams.png"
        ],
        [
            "url" => "http://greenpathenergy.ca/",
            "img" => "/img/company-greenpath.png"
        ],
        [
            "url" => "http://dlmoilfield.com/index.php",
            "img" => "/img/company-dlm.png"
        ],
        [
            "url" => "http://treetime.ca/",
            "img" => "/img/company-treetime.png"
        ],
        [
            "url" => "http://rbsbulk.com/",
            "img" => "/img/company-rbsbulk.png"
        ],
        [
            "url" => "http://www.yellowpages.ca/bus/Alberta/Bonnyville/S-T-Energy-Services-Ltd/4155643.html",
            "img" => "/img/company-stenergy.png"
        ],
        [
            "url" => "http://www.daylighthydrovac.com/",
            "img" => "/img/company-dailight.png"
        ]
    ];    
    shuffle($companies); 
    $companies = array_slice($companies, 0,$limit);
?>
<ul class="sps">
    @foreach($companies  as $company)
    <li class="sps-item">
        <a href="{!! $company["url"] !!}" target=_blank rel="nofollow">
            <img src="{!! $company["img"] !!}" class="sps-img">
        </a>
    </li>
    @endforeach
</ul>