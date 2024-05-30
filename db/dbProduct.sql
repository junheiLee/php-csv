drop table tProduct;
drop table tCategory;

-- 대분류
CREATE TABLE tCategory (
	nCategoryCode INTEGER NOT NULL,
	sCategoryName VARCHAR(100) NULL
) DEFAULT CHARSET=utf8;

-- 대분류
ALTER TABLE tCategory
	ADD CONSTRAINT nCategorySeq -- 분류 기본키
	PRIMARY KEY (
	nCategoryCode -- 대분류코드
	);

-- 상품
CREATE TABLE tProduct (
	nProductCode INTEGER NOT NULL,
	nCategoryCode INTEGER NOT NULL,
	sProductName VARCHAR(100) NOT NULL,
	sDescription VARCHAR(800) NULL,
	nLowestPrice INTEGER NOT NULL
) DEFAULT CHARSET=utf8;

-- 상품
ALTER TABLE tProduct
	ADD CONSTRAINT PK_tProduct -- 상품 기본키
	PRIMARY KEY (
	nProductCode  -- 상품코드
	);

-- 상품
ALTER TABLE tProduct
	ADD CONSTRAINT FK_tCategory_TO_tProduct -- 대분류 -> 상품
	FOREIGN KEY (
	nCategoryCode -- 대분류코드
	)
	REFERENCES tCategory ( -- 대분류
	nCategoryCode -- 대분류코드
	);