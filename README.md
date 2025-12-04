# Segurança Facial: Reconhecimento Facial para Escolas

**Segurança Facial** é um sistema completo de reconhecimento facial desenvolvido como Trabalho de Conclusão de Curso (TCC), criado para modernizar e elevar o nível de segurança no controle de saída de alunos em escolas.  
A solução integra uma plataforma web de gestão com um microsserviço de Inteligência Artificial, garantindo que apenas responsáveis autorizados possam retirar as crianças.

---

## 🚀 Visão Geral do Projeto

O sistema combina **tecnologias modernas**, **experiência do usuário**, **segurança de dados** e **IA de alta precisão** para substituir controles manuais ou crachás físicos, reduzindo fraudes e aumentando a tranquilidade de pais e escolas.

---

## Arquitetura do Sistema

A arquitetura é **híbrida**, integrando dois ambientes principais:

---

### 🔹 Backend de Gestão (PHP + MySQL)

Responsável pelo cadastro e gerenciamento de:

- Instituições  
- Alunos  
- Turmas  
- Responsáveis  
- Histórico de saídas  

---

### 🔹 Microsserviço de IA (Python + Flask)

Realiza:

- Processamento de imagens  
- Extração de características faciais  
- Geração e comparação de *encodings*  
- Comunicação via API REST com o sistema PHP  

---

## 💻 Plataforma Web (Frontend)

- HTML, CSS e JavaScript para construção de interfaces modernas e responsivas  
- Suporte a **Modo Claro/Escuro** 
- Chatbot personalizado (JavaScript puro — `main.js`)  
- Animações com **AOS.js**  
- Carrosséis com **Swiper.js**  

---

## 🧠 Inteligência Artificial (Python)

O reconhecimento facial é realizado através de um microsserviço que utiliza:

- Python **3.10+**  
- **Flask** (API REST)  
- **face_recognition** + **dlib**  
- **OpenCV**  
- **NumPy**  

---

## ⚙️ Fluxo de Processamento da IA

### 📸 Captura  
O frontend captura a imagem da webcam e envia em Base64 ao servidor Python.

### 🔍 Extração de Características  
A API Flask interpreta a imagem, extrai o encoding facial e converte em vetores numéricos.

### 💾 Armazenamento Otimizado  
Os encodings são convertidos em bytes e armazenados como arquivos `.npy`, garantindo:

- Uso mínimo de armazenamento  
- Consultas rápidas  
- Escalabilidade  

Esse método é mais eficiente do que armazenar imagens em alta resolução no banco de dados.

---

## Funcionalidades Principais

- Cadastro completo de alunos, turmas e responsáveis  
- Envio de múltiplas fotos para treino da IA  
- Reconhecimento facial em tempo real no painel web  
- Histórico detalhado de retiradas  
- Integração Web + IA via API REST  

---

## 🎯 Objetivo do Projeto

Criar uma solução de validação biométrica acessível, capaz de substituir métodos tradicionais de liberação de alunos, tornando o processo:

- ✔️ Mais seguro  
- ✔️ Mais rápido  
- ✔️ Totalmente auditável  
- ✔️ Moderno e automatizado  

---

## 🌐 Site Comercial

Visualize a interface pública do sistema:  
➡️ **https://mariajuliafelix.github.io/Seguranca-Facial/**

---

## 👨‍💻 Desenvolvedores

Projeto desenvolvido como TCC por:

- **Maria Julia Felix**  
- **Vinicius Donato**  
- **Lucas Miliozzi**  

---

## 📌 Requisitos Técnicos

### 🔧 PHP + MySQL (Painel de Gestão)

- XAMPP (Apache + MySQL)  
- PHP **7.4+** recomendado  
- Importar o banco via arquivo `.sql`  

---

### 🧪 Microsserviço Python (IA)

Instalar dependências:

```bash
pip install -r requirements.txt
``` 

---------------------------------------------------

# Contribuições e Melhorias Futuras

Este projeto foi desenvolvido como TCC, mas possui grande potencial de evolução.
Sinta-se à vontade para contribuir, sugerir melhorias ou abrir issues com novas ideias.
Toda colaboração é bem-vinda!

# Agradecimentos

Agradecemos aos meus colegas de grupos por toda dedicaçã que tivemos com o projeto.
Este trabalho representa não apenas uma solução tecnológica, mas também um passo importante rumo a escolas mais seguras e preparadas para o futuro.

## 🚀 Obrigado por explorar o Segurança Facial!

Se este projeto foi útil ou inspirador para você, não esqueça de deixar uma ⭐ no repositório!
