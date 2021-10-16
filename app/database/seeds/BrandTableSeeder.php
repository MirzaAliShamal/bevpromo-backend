<?php

class BrandTableSeeder extends Seeder {

    public function run()
    {
        DB::table('brands')->truncate();

        Brand::create(['id' => '1', 'name' =>'', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '6', 'name' =>'Absolut Vodka', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '5', 'name' =>'1800Tequila', 'supplier_id' =>'29', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '7', 'name' =>'Acacia Vineyard Wines', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '8', 'name' =>'Asahi Super Dry', 'supplier_id' =>'6', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '9', 'name' =>'Bacardi', 'supplier_id' =>'7', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '10', 'name' =>'Belvedere Vodka', 'supplier_id' =>'23', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '11', 'name' =>'Blackbeard Spiced Rum', 'supplier_id' =>'4', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '12', 'name' =>'Bubbles', 'supplier_id' =>'36', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '13', 'name' =>'BV Coastal Estates', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '14', 'name' =>'Captain Morgan', 'supplier_id' =>'13', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '15', 'name' =>'Chalone', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '16', 'name' =>'Chandon Sparkling Wines', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '17', 'name' =>'Chopin Vodka', 'supplier_id' =>'11', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '18', 'name' =>'CK Mondavi', 'supplier_id' =>'41', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '19', 'name' =>'Concannon', 'supplier_id' =>'1', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '20', 'name' =>'Corralejo Reposado Tequila', 'supplier_id' =>'18', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '22', 'name' =>'Crown Royal', 'supplier_id' =>'13', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '23', 'name' =>'Cruz Tequila', 'supplier_id' =>'12', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '24', 'name' =>'Cruzan Rum', 'supplier_id' =>'19', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '25', 'name' =>'DeKuyper', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '26', 'name' =>'Domaine Ste Michelle', 'supplier_id' =>'1', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '27', 'name' =>'DonQ', 'supplier_id' =>'4', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '28', 'name' =>'El Jimador', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '29', 'name' =>'Grand Marnier', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '30', 'name' =>'Guinness', 'supplier_id' =>'14', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '31', 'name' =>'Hennessy Black', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '32', 'name' =>'Hennessy Cognac VS', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '33', 'name' =>'Hornitos Tequila', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '34', 'name' =>'Jack Daniels', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '35', 'name' =>'Jagermeister', 'supplier_id' =>'31', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '36', 'name' =>'Jameson Irish Whisky', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '37', 'name' =>'Jeremiah Weed', 'supplier_id' =>'14', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '38', 'name' =>'Jim Beam', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '39', 'name' =>'Jose Cuervo', 'supplier_id' =>'29', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '40', 'name' =>'Kahula', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '41', 'name' =>'Kenwood Vineyard Wines', 'supplier_id' =>'21', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '42', 'name' =>'Ketel One', 'supplier_id' =>'13', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '43', 'name' =>'Knob Creek', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '44', 'name' =>'Malibu', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '45', 'name' =>'Miller-Coors', 'supplier_id' =>'24', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '46', 'name' =>'Moet & Chandon Imperial', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '47', 'name' =>'Mooshead Lager', 'supplier_id' =>'26', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '48', 'name' =>'Newton Vineyards Wine', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '49', 'name' =>'Newton Wines', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '50', 'name' =>'Red Stag', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '51', 'name' =>'Red Stripe', 'supplier_id' =>'14', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '52', 'name' =>'Rosenblum', 'supplier_id' =>'1', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '53', 'name' =>'Sauza Gold', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '54', 'name' =>'Sauza Silver', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '55', 'name' =>'Smirnoff Ice', 'supplier_id' =>'14', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '56', 'name' =>'Smirnoff Vodka', 'supplier_id' =>'13', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '57', 'name' =>'Smithwicks', 'supplier_id' =>'14', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '58', 'name' =>'Snap Dragon', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '59', 'name' =>'Southern Comfort', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '60', 'name' =>'Sterling Vineyard Wines', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '61', 'name' =>'Admiral Nelson', 'supplier_id' =>'22', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '62', 'name' =>'Adult Chocolate Milk', 'supplier_id' =>'5', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '63', 'name' =>'Ardbeg 10 Year Old Single Malt', 'supplier_id' =>'25', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '64', 'name' =>'Barenjager', 'supplier_id' =>'31', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '65', 'name' =>'Basil Hayden', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '66', 'name' =>'Beefeater London Gin', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '67', 'name' =>'Bolla Wines', 'supplier_id' =>'8', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '68', 'name' =>'Brancott', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '69', 'name' =>'BV Napa', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '70', 'name' =>'Cabo Wabo', 'supplier_id' =>'32', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '71', 'name' =>'Canadian Club', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '72', 'name' =>'Canadian Mist', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '73', 'name' =>'Carolan\'s Irish Cream', 'supplier_id' =>'32', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '74', 'name' =>'Courvoisier', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '75', 'name' =>'Dos Equis', 'supplier_id' =>'17', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '76', 'name' =>'Early Times Kentucky Whisky', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '77', 'name' =>'Effen Vodka', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '78', 'name' =>'Evan Williams Bourbon', 'supplier_id' =>'1', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '79', 'name' =>'Finlandia Voka', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '80', 'name' =>'Georges Duboeuf', 'supplier_id' =>'33', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '81', 'name' =>'Glen Garioch Highland Single Malt Scotch Whisky', 'supplier_id' =>'32', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '82', 'name' =>'Graffigna', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '83', 'name' =>'Grolsch', 'supplier_id' =>'24', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '84', 'name' =>'Herradura Tequila', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '85', 'name' =>'Korbel California Champagne', 'supplier_id' =>'9', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '86', 'name' =>'Kunde Wine', 'supplier_id' =>'33', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '87', 'name' =>'Laphroaig', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '88', 'name' =>'Luksusowa Vodka', 'supplier_id' =>'33', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '89', 'name' =>'Peroni', 'supplier_id' =>'24', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '90', 'name' =>'Prairie Organic Vodka', 'supplier_id' =>'28', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '91', 'name' =>'Ruta 22', 'supplier_id' =>'36', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '92', 'name' =>'Sailor Jerry', 'supplier_id' =>'34', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '93', 'name' =>'Sauza Conmemorativo', 'supplier_id' =>'20', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '94', 'name' =>'Seagram\'s Brazilian Rum', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '95', 'name' =>'Seagram\'s Extra Vodka', 'supplier_id' =>'18', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '96', 'name' =>'Seagram\'s Gin', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '97', 'name' =>'Speyburn Single Malt', 'supplier_id' =>'1', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '98', 'name' =>'Stolichnaya Vodka', 'supplier_id' =>'34', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '99', 'name' =>'Skyy Infusions', 'supplier_id' =>'32', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '100', 'name' =>'Old Milwaukee', 'supplier_id' =>'37', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '101', 'name' =>'PBR', 'supplier_id' =>'37', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '102', 'name' =>'OFCRS', 'supplier_id' =>'0', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '103', 'name' =>'Supervalu', 'supplier_id' =>'0', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '104', 'name' =>'Al\'s Mini Mart', 'supplier_id' =>'0', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '105', 'name' =>'Al\'s Mini Mart', 'supplier_id' =>'0', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '106', 'name' =>'Pandemonium', 'supplier_id' =>'39', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '107', 'name' =>'New Age', 'supplier_id' =>'38', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '108', 'name' =>'Sensual Malbec', 'supplier_id' =>'38', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '109', 'name' =>'Svedka', 'supplier_id' =>'40', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '110', 'name' =>'Three Olives', 'supplier_id' =>'29', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '111', 'name' =>'Sterling Vineyards', 'supplier_id' =>'10', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '112', 'name' =>'Tito\'s', 'supplier_id' =>'42', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '113', 'name' =>'Casa Lapostolle', 'supplier_id' =>'43', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '114', 'name' =>'UV Vodka', 'supplier_id' =>'44', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '115', 'name' =>'Rosenblum', 'supplier_id' =>'45', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '116', 'name' =>'Cazadores', 'supplier_id' =>'7', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '117', 'name' =>'Sam Adams', 'supplier_id' =>'46', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '118', 'name' =>'Beringer White Zinfandel', 'supplier_id' =>'47', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '119', 'name' =>'Beringer Pink Moscato', 'supplier_id' =>'47', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '120', 'name' =>'Murphy-Goode', 'supplier_id' =>'48', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '121', 'name' =>'Agave Underground', 'supplier_id' =>'49', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '122', 'name' =>'Caliche Rum', 'supplier_id' =>'4', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '123', 'name' =>'Elsa', 'supplier_id' =>'38', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '124', 'name' =>'Two Angels', 'supplier_id' =>'38', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '125', 'name' =>'Skinnygirl Cocktails', 'supplier_id' =>'50', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '126', 'name' =>'Goslings Bermuda Black Rum', 'supplier_id' =>'51', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '127', 'name' =>'Goslings Seal Rum', 'supplier_id' =>'51', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '128', 'name' =>'American Harvest', 'supplier_id' =>'52', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '129', 'name' =>'Yellow Tail Wine', 'supplier_id' =>'33', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '130', 'name' =>'Deschutes', 'supplier_id' =>'53', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '131', 'name' =>'A to Z Pinot Noir', 'supplier_id' =>'54', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '132', 'name' =>'Charles Smith Wine', 'supplier_id' =>'55', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '133', 'name' =>'Sessions Lager', 'supplier_id' =>'56', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '134', 'name' =>'Yellow Tail', 'supplier_id' =>'57', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '135', 'name' =>'Kendall-Jackson', 'supplier_id' =>'58', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '136', 'name' =>'Jacob\'s Creek Moscato', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '137', 'name' =>'Brancott Estate', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '138', 'name' =>'Absolut Vodka', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '139', 'name' =>'Jameson Irish Whiskey', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '140', 'name' =>'Malibu Rum', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '141', 'name' =>'Absolut/Jameson/Malibu', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '142', 'name' =>'Licor 43', 'supplier_id' =>'59', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '143', 'name' =>'Barking Squirrel', 'supplier_id' =>'26', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '144', 'name' =>'Glenlivet', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '145', 'name' =>'Bombay Sapphire', 'supplier_id' =>'7', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '146', 'name' =>'Dewar\'s', 'supplier_id' =>'7', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '147', 'name' =>'CupCake Wines', 'supplier_id' =>'60', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '148', 'name' =>'Chivas Regal', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '149', 'name' =>'Seagram\'s Escapes', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '150', 'name' =>'Tito\'s', 'supplier_id' =>'42', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '152', 'name' =>'New Amsterdam Gin or Vodka', 'supplier_id' =>'61', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '153', 'name' =>'Arizona Stronghold Wine', 'supplier_id' =>'62', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '154', 'name' =>'Pearl Vodka', 'supplier_id' =>'63', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '155', 'name' =>'McManis Wines', 'supplier_id' =>'64', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '156', 'name' =>'Krave Jerky', 'supplier_id' =>'65', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '157', 'name' =>'dunlivet Scotch', 'supplier_id' =>'66', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '158', 'name' =>'Triple Sec', 'supplier_id' =>'67', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '159', 'name' =>'Peachy Canyon', 'supplier_id' =>'68', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '160', 'name' =>'Decoy Wines', 'supplier_id' =>'69', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '161', 'name' =>'Dead Bolt', 'supplier_id' =>'30', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '162', 'name' =>'Pinx Skinny To Go Cocktails', 'supplier_id' =>'70', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '163', 'name' =>'Eppa SuperFruta', 'supplier_id' =>'33', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '164', 'name' =>'Jordan\'s Skinny Mixes', 'supplier_id' =>'71', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '165', 'name' =>'Hop City', 'supplier_id' =>'26', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '166', 'name' =>'Luna Malvada', 'supplier_id' =>'72', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '167', 'name' =>'Kringle Cream', 'supplier_id' =>'75', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '168', 'name' =>'Midnight Moonshine', 'supplier_id' =>'74', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '169', 'name' =>'Wolfschmidt', 'supplier_id' =>'22', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '170', 'name' =>'Stolichnaya', 'supplier_id' =>'76', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '171', 'name' =>'Marques de Caceres', 'supplier_id' =>'77', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '172', 'name' =>'Flip Flop', 'supplier_id' =>'78', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '173', 'name' =>'Jewel Box', 'supplier_id' =>'78', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '174', 'name' =>'No. 209', 'supplier_id' =>'79', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '175', 'name' =>'Jam Jar', 'supplier_id' =>'80', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '176', 'name' =>'Mosca', 'supplier_id' =>'81', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '177', 'name' =>'Gancia', 'supplier_id' =>'78', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '178', 'name' =>'Indaba ', 'supplier_id' =>'80', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '179', 'name' =>'Modelo ', 'supplier_id' =>'82', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '180', 'name' =>'Paddy Irish Whiskey ', 'supplier_id' =>'27', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '181', 'name' =>'Johnnie Walker/Ketel One', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '182', 'name' =>'Glenmorangie', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '183', 'name' =>'Tropical Moscato and Mochetto', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '184', 'name' =>'ROJO', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '185', 'name' =>'Big House', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '186', 'name' =>'Maryhill', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '187', 'name' =>'Stoli', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '188', 'name' =>'Trapiche', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '189', 'name' =>'Josh Cellars', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '190', 'name' =>'Death\'s Door', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '191', 'name' =>'Avion', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '192', 'name' =>'Ironstone', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);
        Brand::create(['id' => '193', 'name' =>'Mochetto', 'supplier_id' =>'', 'irc_active' =>'1', 'mir_active' =>'1']);

    }

}