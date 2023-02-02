<?

class RequestVelogAPI {

    function curlTitle($userName, $postCursor = null) {

        $postCursor = $postCursor == null ? '' : ',"cursor": "' . $postCursor . '"';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://v2cdn.velog.io/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);


        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"operationName":"Posts","variables":{"username":"'.$userName.'","tag":null'.$postCursor.'},"query":"query Posts($cursor: ID, $username: String, $temp_only: Boolean, $tag: String, $limit: Int) {\n  posts(cursor: $cursor, username: $username, temp_only: $temp_only, tag: $tag, limit: $limit) {\n    id\n    title\n    short_description\n    thumbnail\n    user {\n      id\n      username\n      profile {\n        id\n        thumbnail\n        __typename\n      }\n      __typename\n    }\n    url_slug\n    released_at\n    updated_at\n    comments_count\n    tags\n    is_private\n    likes\n    __typename\n  }\n}\n"}');

        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    function curlPost($postTitle) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://v2cdn.velog.io/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);


        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"operationName":"ReadPost","query":"query ReadPost($username: String, $url_slug: String) { post(username: $username, url_slug: $url_slug) { id title released_at updated_at tags body short_description is_markdown is_private is_temp thumbnail comments_count url_slug likes liked user { id username profile { id display_name thumbnail short_bio profile_links __typename } velog_config { title __typename } __typename } comments { id user { id username profile { id thumbnail __typename } __typename } text replies_count level created_at level deleted __typename } series { id name url_slug series_posts { id post { id title url_slug user { id username __typename } __typename } __typename } __typename } linked_posts { previous { id title url_slug user { id username __typename } __typename } next { id title url_slug user { id username __typename } __typename } __typename } __typename } }","variables":{"username":"gillog","url_slug":"'.$postTitle.'"}}');

        //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"operationName":"PostView","variables":{"id":"' . $postId .'"},"query":"mutation PostView($id: ID!) {\n  postView(id: $id)\n}\n"}');

        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
