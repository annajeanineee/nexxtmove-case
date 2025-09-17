# Nexxtmove – Full-Stack Case (Laravel + Vue)

## Pitch: Woningoverzicht bouwen in Nexxtmove

### Probleem
Makelaars willen snel een overzicht van hun woningen kunnen tonen, filteren en detailinformatie inzien.  
Op dit moment ontbreekt een eenvoudige en flexibele interface hiervoor.

### Appetite
De opdracht mag maximaal **5 uur** duren.  
Het hoeft dus geen complete, pixel-perfecte, productie-ready oplossing te zijn, maar we willen zien hoe je **prioriteiten stelt** en een **werkend minimum** oplevert.

### Solution
De makelaar moet een eenvoudig overzicht van woningen kunnen openen. In dit overzicht kan hij/zij de lijst woningen doorzoeken en filteren.

Belangrijkste wensen vanuit de makelaar:
- Toon een lijst van beschikbare woningen met basisinformatie (**titel, prijs, plaats, status**).  
- De makelaar wil snel kunnen filteren op **plaats**, **status** en **prijsklasse**, zodat hij alleen relevante woningen ziet.  
- Het moet mogelijk zijn om meer informatie over een woning te bekijken, bijvoorbeeld door te klikken op een woning en dan de **details** te tonen.  

**Optioneel (als er tijd is):**
- Sorteren van woningen op prijs of plaats.  
- Paginatie bij een grotere lijst.  
- Een visuele weergave, zoals een grafiek met aantal woningen per stad.  

Het eindresultaat hoeft niet groot of perfect te zijn, maar moet laten zien hoe jij een eerste **werkend minimum** maakt waarmee een makelaar daadwerkelijk woningen kan bekijken en filteren.

### Rabbit Holes
- UI hoeft niet perfect gestyled te zijn → **functionaliteit boven vorm**.  
- Ga niet te veel tijd verliezen aan advanced frontend-state oplossingen (Vuex/Pinia is nice, maar niet verplicht).  
- Security/authenticatie is **buiten scope**.  
- Alleen woningen ophalen, **geen admin omgeving of CMS-functionaliteit**.  

### No-Gos
- Geen focus op pixel-perfect design.  
- Geen extra frameworks naast Laravel en Vue.  

### Wat we willen zien
- Hoe je de **aanpak kiest** en je eigen scope afbakent.  
- Hoe je een **minimum werkend resultaat** oplevert.  
- Hoe je de **stack toepast** (Laravel API + Vue-frontend).  
- Hoe je **samenwerkt en communiceert** (stel je vragen, leg je keuzes uit).  

---

## Setup & Starten

> Vereisten: Docker Desktop actief.

```bash
# 1) .env aanmaken en key genereren
cp .env.example .env
php artisan key:generate

# 2) SQLite DB klaarzetten
mkdir -p database && touch database/database.sqlite
# Zorg in .env dat DB_CONNECTION=sqlite staat

# 3) Containers starten
./vendor/bin/sail up -d

# 4) Migraties/seeders (voeg die zelf toe)
./vendor/bin/sail artisan migrate --seed

---

## Beoordeling & eind
Wanneer je klaar bent met de opdracht zien we graag een PR met hierin een uitleg van je oplossing en wat je allemaal hebt overwogen. We zullen vervolgens samen zitten voor een demo om dit te bespreken. 

# 5) Frontend starten
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
