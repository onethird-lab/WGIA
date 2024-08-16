![image](https://github.com/user-attachments/assets/c8fbd540-09d3-4969-92d1-5cf10e43e9d0)![image](https://github.com/user-attachments/assets/118f7753-4765-48be-a235-2e916c7cc3b5)![image](https://github.com/user-attachments/assets/01ce2915-5509-42e1-b081-ce4b88138645)![image](https://github.com/user-attachments/assets/d79d857d-c741-44f8-900c-0d3ec03272a9)# WGIA
WGIA: GPU-accelerated whole-genome interaction analyzing for everyone

## Introduction
<strong>WGIA is an open-access web application developed for genome-wide interaction analysis</strong>. WGIA leverages GPU parallel technologies to significantly enhance computational efficiency. Its framework facilitates high-speed pairwise interaction analysis, enabling extensive exploration of genome-wide interactions in the era of big data in molecular biology.<br>
<img src="/dblogo/index/2.png" style="max-width: 70%; display: inline-block;" data-target="animated-image.originalImage">
<strong>WGIA incorporates over 70 interaction processing functions</strong>, including correlation analysis within the same omics biomarkers (such as co-expression or differential co-expression for microarray and RNA-seq data, epigenetic interaction analysis, SNP-SNP interaction analysis) and the analysis of regulatory effects between different omics biomarkers (e.g., eQTLs, mQTLs, pQTLs).

## interaction analysis for each omics
### Single nucleotide polymorphism (SNP)
    - [LD](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_SNP_LD)
      <br>optional models: Dprime; Rsquare
    - [SNP×SNP Interaction (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_SNP_Diff)
      <br>Optional models: aa\*bb_vs_other; aa\*Bb_vs_other; aa\*BB_vs_other; Aa\*bb_vs_other; Aa\*Bb_vs_other; Aa\*BB_vs_other; AA\*bb_vs_other; AA\*Bb_vs_other; AA\*BB_vs_other; (AA+Aa)\*(BB+Bb)_vs_other; (AA+Aa)\*(BB)_vs_other; (AA)\*(BB+Bb)_vs_other; (AA)\*(BB)_vs_other; 
    - [mQTL identification (SNP×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_DNAm)
    - [eQTL identification (SNP×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_mRNA)
    - [eQTL identification (SNP×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_microRNA)
    - [eQTL identification (SNP×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_lncRNA)
    - [pQTL identification (SNP×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_Protein)
### Copy number variation (CNV)
    - [CoCNV](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_CNV_Cor)
    <br>Optional models: Pearson; Spearman
    - [CoCNV (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_CNV_DiffCor)
    <br>Optional models: Pearson; Spearman
    - [mQTL identification (CNV×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_DNAm)
    - [eQTL identification (CNV×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_mRNA)
    - [eQTL identification (CNV×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_microRNA)
    - [eQTL identification (CNV×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_lncRNA)
    - [pQTL identification (CNV×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_Protein)
### DNA methylation (DNAm)
    - [CoMethy](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_DNAm_Cor)
    <br>Optional models: Pearson; Spearman
    - [CoMethy (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_DNAm_DiffCor)
    <br>Optional models: Pearson; Spearman
    - [mQTL identification (SNP×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_DNAm)
    - [mQTL identification (CNV×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_DNAm)
    - [eQTM identification (DNAm×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_mRNA)
    - [eQTM identification (DNAm×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_microRNA)
    - [eQTM identification (DNAm×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_lncRNA)
    - [pQTM identification (DNAm×protein)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_Protein)
### mRNA expression (mRNA)
    - [eQTL identification (SNP×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_mRNA)
    - [eQTL identification (CNV×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_mRNA)
    - [eQTM identification (DNAm×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_mRNA)
    - [CoExpression (mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=mRNA_mRNA_Cor)
    <br>Optional models: Pearson; Spearman 
    - [CoExpression (mRNA, case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=mRNA_mRNA_DiffCor)
    <br>Optional models: Pearson; Spearman 
    - [Regulatory relationship identification (miRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_mRNA)
    - [Regulatory relationship identification (lncRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_mRNA)
### microRNA expression (miRNA)
    - [eQTL identification (SNP×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_microRNA)
    - [eQTL identification (CNV×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_microRNA)
    - [eQTM identification (DNAm×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_microRNA)
    - [Regulatory relationship identification (miRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_mRNA)
    - [Regulatory relationship identification (miRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_mRNA)
    - [CoExpression (miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_microRNA_Cor)
    <br>Optional models: Pearson; Spearman 
    - [CoExpression (miRNA, case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_microRNA_DiffCor)
    <br>Optional models: Pearson; Spearman 
### long non-coding RNA expression (lncRNA)
    - [eQTL identification (SNP×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_lncRNA)
    - [eQTL identification (CNV×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_lncRNA)
    - [eQTM identification (DNAm×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_lncRNA)
    - [Regulatory relationship identification (lncRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_mRNA)
    - [CoExpression (lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_lncRNA_Cor)
    <br>Optional models: Pearson; Spearman 
    - [CoExpression (lncRNA, case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_lncRNA_DiffCor)
    <br>Optional models: Pearson; Spearman 
### protein expression (protein)
    - [pQTL identification (SNP×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_Protein)
    - [pQTL identification (CNV×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_Protein)
    - [pQTM identification (DNAm×protein)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_Protein)
    - [PPI](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=Protein_Protein_Cor)
    <br>Optional models: Pearson; Spearman 
    - [PPI (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=Protein_Protein_DiffCor)
    <br>Optional models: Pearson; Spearman 

## Tutorials
- [Home](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab2)
- [job_center](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab3)
- [start_analysis](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab4)
- [job_status](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab5)
- [query_report](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab6)
- [software](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab7)
- [contact](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab8)
- [login](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab9)
- [register](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab10)
- [FAQ](http://gpu.zjwm.cc/wgia/index.php/Index/tutorial#tab5)

