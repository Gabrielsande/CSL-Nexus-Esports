-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/04/2026 às 07:33
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `noticiasge`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `noticia` text NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `autor` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `noticia`, `data`, `autor`, `imagem`, `categoria`) VALUES
(10, 'Domine o competitivo: Guia completo para subir de elo em FPS', 'O cenário competitivo dos jogos de tiro em primeira pessoa tem se tornado cada vez mais exigente, tanto para jogadores iniciantes quanto para aqueles que já possuem experiência. Evoluir dentro desse ambiente não depende apenas de talento, mas de disciplina, estratégia e constância.\r\n\r\nUm dos pilares fundamentais para o crescimento no competitivo é o domínio da mecânica básica. Mira, movimentação e controle de recuo são habilidades essenciais que precisam ser treinadas diariamente. Ferramentas como mapas de treino e modos específicos de prática ajudam a desenvolver esses aspectos com mais eficiência.\r\n\r\nOutro fator determinante é a comunicação em equipe. Em jogos competitivos, a troca de informações rápidas e objetivas pode definir o resultado de uma partida. Jogadores que sabem se comunicar de forma clara possuem uma vantagem significativa sobre aqueles que jogam de forma individualista.\r\n\r\nAlém disso, analisar partidas anteriores é uma prática extremamente importante. Rever erros, identificar decisões equivocadas e entender o posicionamento em momentos críticos contribuem diretamente para a evolução do jogador.\r\n\r\nPor fim, a consistência é o diferencial. Não basta jogar bem em momentos isolados — é necessário manter um desempenho estável ao longo do tempo. Com dedicação e prática contínua, qualquer jogador pode subir de nível e alcançar melhores resultados no competitivo.', '2026-04-13 02:04:57', 3, 'img_69dc7979ae70c.jpg', 'guias'),
(11, 'Setup gamer econômico: como montar um bom PC gastando pouco', 'Montar um setup gamer de qualidade não precisa, necessariamente, exigir um investimento elevado. Com planejamento e escolhas estratégicas, é possível construir uma máquina eficiente capaz de rodar diversos jogos atuais.\r\n\r\nO primeiro passo é definir prioridades. Componentes como processador, memória RAM e armazenamento devem ser escolhidos com cuidado, pois impactam diretamente no desempenho geral do sistema. Um processador intermediário aliado a 8GB ou 16GB de RAM e um SSD já garante uma experiência fluida na maioria dos jogos.\r\n\r\nA placa de vídeo, por sua vez, pode representar o maior custo do setup. Uma alternativa interessante é buscar modelos usados em boas condições, o que pode reduzir significativamente o valor total do investimento.\r\n\r\nNos periféricos, como teclado, mouse e monitor, o ideal é focar na funcionalidade antes da estética. Equipamentos simples podem atender perfeitamente às necessidades iniciais do jogador.\r\n\r\nCom o tempo, upgrades podem ser realizados de forma gradual, permitindo que o setup evolua conforme as demandas aumentam. Dessa forma, o jogador consegue entrar no mundo gamer sem comprometer seu orçamento.', '2026-04-13 02:07:04', 3, 'img_69dc79f87c32b.jpg', 'guias'),
(12, 'O crescimento dos eSports e o impacto no mercado global', 'Os esportes eletrônicos, conhecidos como eSports, deixaram de ser apenas uma forma de entretenimento para se tornarem uma indústria consolidada e altamente lucrativa. Nos últimos anos, o crescimento desse setor tem sido impulsionado por diversos fatores, incluindo o aumento da audiência, investimentos de grandes marcas e a profissionalização das equipes.\r\n\r\nEventos internacionais atraem milhões de espectadores ao redor do mundo, com transmissões ao vivo que rivalizam com esportes tradicionais. Além disso, premiações milionárias e contratos de patrocínio reforçam a importância econômica do setor.\r\n\r\nNo Brasil, o cenário também se destaca. O país possui uma das maiores comunidades gamers do mundo e tem revelado talentos que competem em alto nível no cenário internacional.\r\n\r\nOutro ponto relevante é a expansão das oportunidades de carreira. Hoje, além dos jogadores profissionais, existem diversas funções dentro do ecossistema dos eSports, como analistas, treinadores, narradores e criadores de conteúdo.\r\n\r\nO futuro dos eSports aponta para um crescimento ainda maior, com novas tecnologias e maior integração com o entretenimento digital.', '2026-04-13 02:08:30', 3, 'img_69dc7a4e88a10.jpg', 'mundo_gamer'),
(13, 'Nexus Esports: a nova referência em conteúdo gamer competitivo', 'Os esportes eletrônicos, conhecidos como eSports, deixaram de ser apenas uma forma de entretenimento para se tornarem uma indústria consolidada e altamente lucrativa. Nos últimos anos, o crescimento desse setor tem sido impulsionado por diversos fatores, incluindo o aumento da audiência, investimentos de grandes marcas e a profissionalização das equipes.\r\n\r\nEventos internacionais atraem milhões de espectadores ao redor do mundo, com transmissões ao vivo que rivalizam com esportes tradicionais. Além disso, premiações milionárias e contratos de patrocínio reforçam a importância econômica do setor.\r\n\r\nNo Brasil, o cenário também se destaca. O país possui uma das maiores comunidades gamers do mundo e tem revelado talentos que competem em alto nível no cenário internacional.\r\n\r\nOutro ponto relevante é a expansão das oportunidades de carreira. Hoje, além dos jogadores profissionais, existem diversas funções dentro do ecossistema dos eSports, como analistas, treinadores, narradores e criadores de conteúdo.\r\n\r\nO futuro dos eSports aponta para um crescimento ainda maior, com novas tecnologias e maior integração com o entretenimento digital.', '2026-04-13 02:11:44', 3, 'img_69dc7b105a293.png', 'lancamentos'),
(14, 'Campeonato internacional bate recorde e consolida crescimento dos eSports', 'O cenário competitivo alcançou um novo marco com a realização de um campeonato internacional que registrou números impressionantes de audiência.\r\n\r\nMilhões de espectadores acompanharam as partidas ao vivo, evidenciando o crescimento contínuo dos eSports como forma de entretenimento global.\r\n\r\nA competição contou com equipes de alto nível e apresentou partidas intensas, mantendo o público engajado do início ao fim.\r\n\r\nO sucesso do evento reforça a relevância dos eSports no cenário atual e indica um futuro ainda mais promissor para a indústria.', '2026-04-13 02:14:14', 2, 'img_69dc7ba61b466.jpg', 'games'),
(15, 'Atualização recente muda completamente o meta competitivo', 'Uma nova atualização trouxe mudanças significativas que impactaram diretamente o cenário competitivo do jogo.\r\n\r\nAlterações em armas, habilidades e mecânicas obrigaram jogadores profissionais a repensarem suas estratégias e estilos de jogo.\r\n\r\nO novo meta tem favorecido abordagens mais táticas, aumentando a complexidade das partidas e exigindo maior adaptação por parte dos jogadores.', '2026-04-13 02:16:00', 2, 'img_69dc7c10d9d1b.jpg', 'games'),
(16, 'GTA 6 lidera nova geração de jogos e redefine o conceito de mundo aberto', 'Poucos jogos na história geraram tanta expectativa quanto Grand Theft Auto VI, previsto para lançamento em novembro de 2026. O título da Rockstar chega com a responsabilidade de superar o sucesso massivo de seu antecessor e redefinir o padrão dos jogos de mundo aberto.\r\n\r\nA nova versão traz uma ambientação moderna inspirada em Vice City, com um mapa dinâmico e altamente detalhado. A promessa é de um mundo vivo, onde cada decisão do jogador impacta diretamente o ambiente e os personagens.\r\n\r\nAlém disso, o jogo deve apresentar avanços significativos em inteligência artificial, permitindo interações mais realistas com NPCs e criando experiências únicas para cada jogador.\r\n\r\nEspecialistas acreditam que GTA 6 não será apenas um jogo, mas um marco na indústria, influenciando futuros títulos por muitos anos.', '2026-04-13 02:18:00', 2, 'img_69dc7c88588a3.jpg', 'lancamentos'),
(17, 'Resident Evil Requiem aposta no terror clássico para reconquistar fãs', 'A franquia Resident Evil retorna em 2026 com Resident Evil Requiem, trazendo uma proposta que mistura nostalgia com inovação.\r\n\r\nO jogo apresenta uma nova protagonista, envolvida em uma investigação em Raccoon City, cenário icônico da série. A proposta é resgatar o terror psicológico e a tensão que consagraram a franquia, ao mesmo tempo em que introduz novas mecânicas de gameplay.\r\n\r\nCom gráficos realistas e ambientação sombria, o título promete uma experiência imersiva, focada no medo e na sobrevivência.\r\n\r\nO retorno às raízes é visto como uma estratégia para reconquistar fãs antigos, ao mesmo tempo em que atrai novos jogadores.', '2026-04-13 02:19:20', 2, NULL, 'lancamentos'),
(18, 'Forza Horizon 6 eleva o nível dos jogos de corrida', 'Os jogos de corrida também ganham destaque em 2026 com o lançamento de Forza Horizon 6, um dos títulos mais aguardados do gênero.\r\n\r\nA nova edição promete um mundo aberto ainda mais detalhado, com cenários inspirados em locais reais e condições climáticas dinâmicas que impactam diretamente a jogabilidade.\r\n\r\nAlém disso, melhorias na física dos veículos e na inteligência artificial tornam as corridas mais realistas e desafiadoras.\r\n\r\nCom foco tanto no público casual quanto competitivo, o jogo deve se consolidar como referência no gênero.', '2026-04-13 02:23:29', 4, 'img_69dc7dd17ffc0.jpg', 'lancamentos'),
(19, 'Slay the Spire 2 promete elevar o nível dos jogos de estratégia', 'A sequência de um dos roguelikes mais aclamados dos últimos anos está chegando. Slay the Spire 2 promete expandir tudo aquilo que tornou o primeiro jogo um sucesso entre os fãs de estratégia.\r\n\r\nO novo título traz cartas inéditas, personagens adicionais e mecânicas mais profundas, aumentando significativamente as possibilidades dentro das partidas. A proposta continua sendo a combinação entre estratégia e imprevisibilidade, característica marcante da franquia.\r\n\r\nOutro ponto importante é a melhoria na interface e na experiência do jogador, tornando o jogo mais acessível para iniciantes sem perder a complexidade que agrada os veteranos.\r\n\r\nCom uma base de fãs consolidada, Slay the Spire 2 tem tudo para se destacar novamente e manter o gênero roguelike em alta.', '2026-04-13 02:25:00', 4, 'img_69dc7e2c2907b.jpg', 'lancamentos'),
(20, 'O crescimento das ligas regionais fortalece o cenário competitivo', 'Nos últimos anos, o crescimento das ligas regionais tem sido um dos principais fatores para o fortalecimento do cenário de eSports. Essas competições permitem que novos talentos surjam e ganhem visibilidade, criando uma base sólida para o futuro do competitivo.\r\n\r\nDiferente dos grandes campeonatos internacionais, as ligas regionais oferecem oportunidades para jogadores iniciantes desenvolverem suas habilidades em um ambiente mais acessível. Isso contribui diretamente para a renovação constante do cenário.\r\n\r\nAlém disso, essas ligas aumentam o engajamento da comunidade local, aproximando fãs e jogadores. O público passa a acompanhar mais de perto as equipes da sua região, criando uma conexão mais forte com o competitivo.\r\n\r\nEspecialistas apontam que o investimento nesse tipo de competição é essencial para o crescimento sustentável dos eSports.', '2026-04-13 02:26:02', 4, 'img_69dc7e6ac1fd7.jpg', 'games'),
(21, 'Jogos online continuam dominando o mercado global', 'Os jogos online seguem como a principal força da indústria gamer em 2026. Com milhões de jogadores ativos diariamente, títulos multiplayer continuam liderando em popularidade e faturamento.\r\n\r\nA facilidade de acesso, aliada à possibilidade de interação social, faz com que esses jogos se mantenham relevantes por longos períodos. Atualizações constantes e eventos dentro dos jogos também ajudam a manter o interesse da comunidade.\r\n\r\nOutro fator importante é o crescimento das plataformas de streaming, que ampliam ainda mais a visibilidade dos jogos online. Jogadores não apenas jogam, mas também acompanham outros jogadores, criando um ciclo contínuo de engajamento.\r\n\r\nCom a evolução da tecnologia e da internet, a tendência é que os jogos online continuem dominando o mercado nos próximos anos.', '2026-04-13 02:27:29', 3, 'img_69dc7ec1c985d.jpg', 'mundo_gamer');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','jornalista') NOT NULL DEFAULT 'jornalista',
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `ativo`, `criado_em`) VALUES
(2, 'Gabriel Sandes', 'gabriel@gabriel.com', '$2y$10$mrs2IoTmuRoQZnHXpKeKW.wrmYKzLdFzFrNzfPJwY3iZ1cY0tvshO', 'jornalista', 1, '2026-04-12 19:56:41'),
(3, 'Admin NexusEsports', 'adminNexus@nexus.com', '$2y$10$SfNjI/r5pM6OSepNE4wrgur9tQ0dWoHFnoxSlF3ykiCxIr/62ATSy', 'admin', 1, '2026-04-13 01:13:42'),
(4, 'sandes', 'sandes@sandes.com', '$2y$10$rbGJw6tpzNSOnj5WDfcNoe7MjsIewUwAJEdVlN7IGeIT8VbsHPJ4m', 'jornalista', 1, '2026-04-13 02:21:16');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
