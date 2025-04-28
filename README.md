# EduZSP
EduZSP to aplikacja webowa stworzona na zaliczenie do szkoły. Ogólny zamysł aplikacji był taki, aby stworzyć stronę do tworzenia testów (pytania zamknięte - cztery odpowiedzi "A" "B" "C" "D"). Projekt wszedł w fazę testów i pierwszych użyć. Został oceniony na ocenę celującą (6), jednakże z powodu zbliżających się matur zrezygnowałem nad dalszym prowadzeniem projektu, jednakże zamierzam zmienić to w najbliższej przyszłości

# Co zawiera:
- EduZSP jest stosunkowo prostą aplikacją (ale piękno leży w prostocie). Wchodząc na stronę główną mamy panel do zalogowania się lub rejestracji. Po rejestracji, admin serwisu (ewentualnie nauczyciel - zależy jak szkoła ustawi uprawnienia) ustala, czy konto należy do ucznia (domyślne ustawienie), nauczyciela czy jest to losowa osoba, której konto należy zablkować/usunąć
- Nauczyciel ma możliwośc tworzenia, usuwania, oraz podglądania swoich testów. Gdy taki test utworzy, dostaje kod do testu, który przekazuje uczniom. Uczniowie logując się na swoje konto mają możliwość wpisania kodu i przejściu do testu. Test trwa określoną, przez nauczyciela, liczbę minut a potem automatycznie się kończy
- Po zakończeniu testu, nauczyciel dostaje podgląd odpowiedzi uczniów (ile poprawnych i ile negatywnych) i jakie oceny im przysługują. Może również wejść w konkretnego ucznia i sprawdzić jakich odpowiedzi udzielił

# Jak sprawdzić aplikację?
Aby sprawdzić działanie aplikacje kliknij [tutaj](https://kolodev.pl/projects/eduzsp/) i zaloguj się na jedno z kont:
  - Admin (Login: admin@admin.pl) (Hasło: admin)
  - Nauczyciel (Login: nauczyciel@nauczyciel.pl) (Hasło: nauczyciel)
  - Uczeń (Login: uczen@uczen.pl) (Hasło: uczen)

# Technologie:
- Front-end:
  - HTML
  - SCSS
  - JavaScript
- Back-end:
  - PHP
  - MySQL
