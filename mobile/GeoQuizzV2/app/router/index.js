/*
Implémentation du routeur pour le mobile : 
->La page indique toutes les routes possibles
->Dans chaque page ou on fait une redirection, il faut implémenter la méthode changeRoute ou on indique la route vers laquelle on veux aller
*/ 

import Picture from '../components/Picture';
import Position from '../components/Position';
import Validation from '../components/Validation';
import MapBox from '../components/MapBox';
import Login from '../components/Login';
import End from '../components/End';

const routes = {
    Picture: Picture,
    Position: Position,
    Validation: Validation,
    MapBox: MapBox,
    Login: Login,
    End: End,
}

export default routes;