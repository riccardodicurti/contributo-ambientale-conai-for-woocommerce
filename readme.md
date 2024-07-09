=== Contributo Ambientale Conai for WooCommerce ===
Contributors: riccardodicurti
Donate link: https://riccardodicurti.it/
Tags: conai, woocommerce
Requires at least: 4.7
Tested up to: 5.4
Stable tag: 1.1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Plugin in fase di sviluppo per l'aggiunta del calcolo relativo al contributo conai in fase di checkout.

## Descrizione 

Il plugin Contributo Ambientale Conai for WooCommerce - Consorzio Nazionale Imballaggi è la risposta all'esigenza di aggiungere il calcolo del Conai al tuo WooCommerce. 

Il plugin sarà visibile unicamente se è attivo ACF PRO e WooCommerce e necessiterà del'inserimento delle configurazioni nel pannello del plugin che troverai nel sottomenu di WooCommerce.

Fai attenzione a non usare id 0 in qunato riservato per gli articoli non soggetti a conai. 

Una volta inseriti i settings nel pannello del plugin vai all'interno dei tuoi prodotti e specifica tipologia di materiale ed il relativo peso. 

Al valore del contibuto conai verrà aggiunta l'aliquota iva scelta nelle impostazione, viene calcolato secondo la seguente formula: 
TARIFFA CONAI ALLA TONNELLATA / 1000 * PESO DEL PRODOTTO IN KG * NUMERO DI PRODOTTI * IVA  

Il plugin sarà presto revisionato e raggiunta una versione stabile verrà rilasciato per il download dalla repository ufficiale di WordPress. Nel caso in cui troviate bugs o vogliate collaborare non esitate a contattarmi.  

## Frequently Asked Questions 

### Dove posso trovare maggiorni informazioni sul contributo ambientale conai ?

Ti consiglio di leggere la pagina presente sul sito ufficiale del conai al riguardo del [CONTRIBUTO AMBIENTALE](http://www.conai.org/imprese/contributo-ambientale/).

## License

This plugin is released under the terms of the GNU General Public License version 2 or (at your option) any later version. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for complete license.

## Changelog 

**1.1.2**
- add compatibility with WooCommerce Tax

**1.1.1**
- fix compatibility problem with ACF

**26062024**
- cleanup
- bugfixing

**10032022**
- new settings page

**09032022**
- fixed error in saving the conai option

**15062020**
- first release
