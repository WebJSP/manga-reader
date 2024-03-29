<?php
session_start();
include('../config/config.inc.php');
include('../phplib/hybridauth/Hybrid/Auth.php');
$provider = filter_input(INPUT_GET, "provider");
if(isset($provider)) {
    try{
        $hybridauth = new Hybrid_Auth( $config );
        $authProvider = $hybridauth->authenticate($provider);
        $user_profile = $authProvider->getUserProfile();
        if($user_profile && isset($user_profile->identifier)) {
            $_SESSION["admin_id"] = $user_profile->identifier;
            $_SESSION["display_name"] = $user_profile->displayName;
            $_SESSION["first_name"] = $user_profile->firstName;
            $_SESSION["photo_url"] = $user_profile->photoURL;
            header("Location: dashboard.php");
        } else {
            session_unset();
            header("location: index.php?noauth=1");
        }
    } catch( Exception $e ) { 
         switch( $e->getCode() ) {
                case 0 : echo "Unspecified error."; break;
                case 1 : echo "Hybridauth configuration error."; break;
                case 2 : echo "Provider not properly configured."; break;
                case 3 : echo "Unknown or disabled provider."; break;
                case 4 : echo "Missing provider application credentials."; break;
                case 5 : echo "Authentication failed The user has canceled the authentication or the provider refused the connection.";
                         break;
                case 6 : echo "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                         $authProvider->logout();
                         break;
                case 7 : echo "User not connected to the provider.";
                         $authProvider->logout();
                         break;
                case 8 : echo "Provider does not support this feature."; break;
        }
        echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
        echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";
    }
}
?>