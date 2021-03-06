USE [artbookapp]
GO
ALTER TABLE [app].[tb_images] DROP CONSTRAINT [FK_tb_images_tb_users1]
GO
ALTER TABLE [app].[tb_images] DROP CONSTRAINT [FK_tb_images_tb_users]
GO
ALTER TABLE [app].[tb_eventos] DROP CONSTRAINT [DF_eventos_creacion]
GO
/****** Object:  Table [app].[tb_users]    Script Date: 9/11/2020 17:44:01 ******/
DROP TABLE [app].[tb_users]
GO
/****** Object:  Table [app].[tb_images]    Script Date: 9/11/2020 17:44:01 ******/
DROP TABLE [app].[tb_images]
GO
/****** Object:  Table [app].[tb_eventos]    Script Date: 9/11/2020 17:44:01 ******/
DROP TABLE [app].[tb_eventos]
GO
/****** Object:  StoredProcedure [app].[sp_images_salvar]    Script Date: 9/11/2020 17:44:01 ******/
DROP PROCEDURE [app].[sp_images_salvar]
GO
/****** Object:  StoredProcedure [app].[sp_images]    Script Date: 9/11/2020 17:44:01 ******/
DROP PROCEDURE [app].[sp_images]
GO
/****** Object:  Schema [app]    Script Date: 9/11/2020 17:44:01 ******/
DROP SCHEMA [app]
GO
/****** Object:  Schema [app]    Script Date: 9/11/2020 17:44:01 ******/
CREATE SCHEMA [app]
GO
/****** Object:  StoredProcedure [app].[sp_images]    Script Date: 9/11/2020 17:44:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROC [app].[sp_images]
AS BEGIN
	SELECT * FROM app.tb_images
END
GO
/****** Object:  StoredProcedure [app].[sp_images_salvar]    Script Date: 9/11/2020 17:44:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROC [app].[sp_images_salvar]
	@id_image bigint = '',
	@accessname [varchar](200),
	@extension [varchar](5),
	@height [int],
	@width [int],
	@autor [bigint],
	@uploaded_user [bigint],
	@name [varchar](20)
AS BEGIN
	
	IF EXISTS(SELECT TOP 1 1 FROM app.tb_images WHERE id_image = @id_image) BEGIN
		UPDATE [app].[tb_images] SET
           accessname = @accessname,
           extension = @extension,
           height = @height,
           width = @width,
           autor = @autor,
           uploaded_user = @uploaded_user,
           uploaded_date = GETDATE(),
           name = @name
		WHERE id_image = @id_image

		SELECT @id_image KeyItem
	END
	ELSE BEGIN
		INSERT INTO [app].[tb_images]
           ([accessname]
           ,[extension]
           ,[height]
           ,[width]
           ,[autor]
           ,[uploaded_user]
           ,[uploaded_date]
           ,[name])
		VALUES
           (@accessname
           ,@extension
           ,@height
           ,@width
           ,@autor
           ,@uploaded_user
           ,GETDATE()
           ,@name)
		   SELECT @@IDENTITY KeyItem
	END
END
GO
/****** Object:  Table [app].[tb_eventos]    Script Date: 9/11/2020 17:44:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [app].[tb_eventos](
	[evento] [bigint] IDENTITY(1,1) NOT NULL,
	[Nombre] [varchar](30) NOT NULL,
	[Descripcion] [varchar](200) NOT NULL,
	[fecha] [datetime] NOT NULL,
	[creacion] [date] NOT NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [app].[tb_images]    Script Date: 9/11/2020 17:44:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [app].[tb_images](
	[id_image] [bigint] IDENTITY(1,1) NOT NULL,
	[accessname] [varchar](200) NOT NULL,
	[extension] [varchar](5) NOT NULL,
	[height] [int] NOT NULL,
	[width] [int] NOT NULL,
	[autor] [bigint] NOT NULL,
	[uploaded_user] [bigint] NOT NULL,
	[uploaded_date] [datetime] NOT NULL,
	[name] [varchar](20) NOT NULL,
 CONSTRAINT [PK_images] PRIMARY KEY CLUSTERED 
(
	[id_image] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [app].[tb_users]    Script Date: 9/11/2020 17:44:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [app].[tb_users](
	[id_user] [bigint] IDENTITY(1,1) NOT NULL,
	[nickname] [varchar](50) NOT NULL,
	[name] [varchar](50) NULL,
	[access] [varchar](20) NOT NULL,
	[pass] [varchar](200) NULL,
	[cellphone] [varchar](50) NULL,
 CONSTRAINT [PK_users] PRIMARY KEY CLUSTERED 
(
	[id_user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [app].[tb_images] ON 

INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (30, N'6e2a2c6a19c927a126a914a2d285c3b4', N'jpg', 2048, 1152, 1, 2, CAST(0x0000AC6E011D7DF7 AS DateTime), N'pan con jamon')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (31, N'MzFzdGFyZmx5', N'jpg', 500, 548, 1, 2, CAST(0x0000AC6D000B7CF9 AS DateTime), N'starfly')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (32, N'MzJwb3BleWUgY2xhc2lj', N'jpg', 414, 567, 1, 2, CAST(0x0000AC6D000B96A8 AS DateTime), N'popeye clasic')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (33, N'2618de29baf8009e3d42227937a37d32', N'jpg', 756, 1280, 1, 2, CAST(0x0000AC6D000D0472 AS DateTime), N'death pool')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (34, N'aa8b8609787760d4d049865ef8d18eca', N'jpg', 534, 750, 1, 2, CAST(0x0000AC6D0167ACF3 AS DateTime), N'SAMURAY')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (35, N'34632af96c33eec1764189a55aa91893', N'jpg', 1280, 720, 1, 2, CAST(0x0000AC6D018AF0CB AS DateTime), N'CAMPOS VERDES')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (36, N'acb124717afb405f4f38cc26f3f381a4', N'png', 1920, 1080, 1, 2, CAST(0x0000AC6E0111BCAA AS DateTime), N'THE MORNING')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (37, N'77316275a92de035db13c03d84b73e56', N'jpg', 2560, 1440, 1, 2, CAST(0x0000AC6E011DB57F AS DateTime), N'The life')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (38, N'86bca656317c983845128241666ea426', N'png', 1920, 1080, 1, 2, CAST(0x0000AC6E012142DC AS DateTime), N'the city')
INSERT [app].[tb_images] ([id_image], [accessname], [extension], [height], [width], [autor], [uploaded_user], [uploaded_date], [name]) VALUES (39, N'ed724741d137cb1190e966324ef243b6', N'jpg', 1920, 1080, 1, 2, CAST(0x0000AC6E0121841A AS DateTime), N'the eyes')
SET IDENTITY_INSERT [app].[tb_images] OFF
SET IDENTITY_INSERT [app].[tb_users] ON 

INSERT [app].[tb_users] ([id_user], [nickname], [name], [access], [pass], [cellphone]) VALUES (1, N'Anonimus', N'Anonimus', N'public', NULL, NULL)
INSERT [app].[tb_users] ([id_user], [nickname], [name], [access], [pass], [cellphone]) VALUES (2, N'cafeconpato', N'DAVID', N'admin', N'01258123Da', NULL)
SET IDENTITY_INSERT [app].[tb_users] OFF
ALTER TABLE [app].[tb_eventos] ADD  CONSTRAINT [DF_eventos_creacion]  DEFAULT (getdate()) FOR [creacion]
GO
ALTER TABLE [app].[tb_images]  WITH CHECK ADD  CONSTRAINT [FK_tb_images_tb_users] FOREIGN KEY([uploaded_user])
REFERENCES [app].[tb_users] ([id_user])
ON UPDATE CASCADE
GO
ALTER TABLE [app].[tb_images] CHECK CONSTRAINT [FK_tb_images_tb_users]
GO
ALTER TABLE [app].[tb_images]  WITH CHECK ADD  CONSTRAINT [FK_tb_images_tb_users1] FOREIGN KEY([autor])
REFERENCES [app].[tb_users] ([id_user])
GO
ALTER TABLE [app].[tb_images] CHECK CONSTRAINT [FK_tb_images_tb_users1]
GO
