=== Estate Launcher Core ===
Contributors: boowmedia
Tags: realitní kancelář, nemovitosti, recenze, CPT, WordPress, makléř
Requires at least: 5.6
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.3.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Modulární základ pro realitní weby na WordPressu – správa nemovitostí, recenzí a kontaktních údajů makléře.

== Description ==

**Estate Launcher Core** je základní modul pro realitní weby, který poskytuje:

- vlastní typy příspěvků pro nemovitosti a recenze,
- snadno přístupnou stránku s ID webu a možností kopírování,
- možnost deaktivace jednotlivých modulů,
- samostatnou sekci pro správu údajů o makléři (jméno, telefon, email),
- čistý a přehledný design v administraci.

Plugin je plně připravený pro rozšíření pomocí dalších modulů nebo napojení na importní můstky.

== Installation ==

1. Nahrajte složku `estate-launcher-core` do `/wp-content/plugins/`.
2. Aktivujte plugin v menu **Pluginy**.
3. V administraci se objeví položka **Estate Launcher**, kde můžete upravit nastavení.

== Frequently Asked Questions ==

= K čemu slouží ID webu? =  
Každá instalace generuje unikátní ID, které může sloužit k identifikaci webu např. při napojení na externí systém.

= Jak dynamicky zobrazím údaje makléře v šabloně? =  
Pomocí vlastních polí (např. `el_agent_phone`, `el_agent_email`) můžete hodnoty vložit přes builder jako dynamická data.

== Changelog ==

= 1.3.0 =
* Přidání nastavení údajů o makléři v administraci
* Shortcody pro snadné vkládání údajů (např. [agent_phone])
* Vylepšený vizuál zpráv a kopírování ID

= 1.2.0 =
* Přidána samostatná sekce pro údaje o makléři (jméno, email, telefon).
* Vylepšený vzhled nastavení a oprava funkce tlačítka „Kopírovat“.
* Interní úpravy kódu a příprava na modulární rozšíření.

= 1.1.1 =
* První ostrá verze s podporou CPT, metaboxů, sloupců a nastavení.
