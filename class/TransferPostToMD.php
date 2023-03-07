<?php

class TransferPostToMD {

    function transferToMD($post) {
        $title = $post['title'];
        $lastModifiedAt =  preg_replace('/:[0-9]{2}\.[0-9]+Z/', '', $post['released_at']);
        $urlSlug = $post['url_slug'];
        $releaseDate = preg_replace('/(T.*?Z)/', '', $post['released_at']);
        $mdTitle = $releaseDate . '-'. $urlSlug;
        $tags = $post['tags'];
        $body = $post['body'];
        $series = $post['series'] != null && $post['series']['name'] != null ? $post['series']['name'] : "";

        $tagTail = '';
        foreach ($tags as $tag) {
            $tagTail .= " \n  - '".$tag."'";
        }
        $tagBody = "\ntags:" .$tagTail;

        $seriesURL = '';
        if($series != "") {
            $seriesURL = preg_replace('/\./', '', strtolower($series));
            $seriesMetaData = "---\ntitle: '".$series."'\nlayout: category\npermalink: /categories/".$seriesURL. "\nauthor_profile: true\nsidebar_main: true\n---\n{% assign posts = site.categories.".$seriesURL." %}\n{% for post in posts %} {% include archive-single.html type=page.entries_layout %} {% endfor %}";

            $seriesFile = fopen("../categories/".'category-'.strtolower($series).".md", "w") or die("Unable to Write file!");
            fwrite($seriesFile, $seriesMetaData);
            fclose($seriesFile);
        }

        $postMetaData = "---\ntitle: \"" .$title . "\"\nlast_modified_at: " . $lastModifiedAt . "\ncategories: \n  - " . $seriesURL . $tagBody . "\ntoc: true\ntoc_label: '목차'\ntoc_icon: 'sort'\ntoc_sticky: true\n---\n";


        $postBody = $postMetaData . $body;

        $postMDFile = fopen("../posts/".$releaseDate.'-'.$urlSlug.".md", "w") or die("Unable to Write file!");
        fwrite($postMDFile, $postBody);
        fclose($postMDFile);


        return $tagBody;
    }
}
