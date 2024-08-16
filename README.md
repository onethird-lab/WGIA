# WGIA
WGIA: GPU-accelerated whole-genome interaction analyzing for everyone

## Introduction
<strong>WGIA is an open-access web application developed for genome-wide interaction analysis</strong>. WGIA leverages GPU parallel technologies to significantly enhance computational efficiency. Its framework facilitates high-speed pairwise interaction analysis, enabling extensive exploration of genome-wide interactions in the era of big data in molecular biology.<br>
<img src="/dblogo/index/2.png" style="max-width: 70%; display: inline-block;" data-target="animated-image.originalImage">
<strong>WGIA incorporates over 70 interaction processing functions</strong>, including correlation analysis within the same omics biomarkers (such as co-expression or differential co-expression for microarray and RNA-seq data, epigenetic interaction analysis, SNP-SNP interaction analysis) and the analysis of regulatory effects between different omics biomarkers (e.g., eQTLs, mQTLs, pQTLs).

## Interaction analysis for each omics
 - <b>Single nucleotide polymorphism (SNP)</b>
    - [LD](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_SNP_LD)
      <br>optional models: Dprime; Rsquare
    - [SNP×SNP Interaction (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_SNP_Diff)
      <br>Optional models: aa\*bb_vs_other; aa\*Bb_vs_other; aa\*BB_vs_other; Aa\*bb_vs_other; Aa\*Bb_vs_other; Aa\*BB_vs_other; AA\*bb_vs_other; AA\*Bb_vs_other; AA\*BB_vs_other; (AA+Aa)\*(BB+Bb)_vs_other; (AA+Aa)\*(BB)_vs_other; (AA)\*(BB+Bb)_vs_other; (AA)\*(BB)_vs_other; 
    - [mQTL identification (SNP×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_DNAm)
    - [eQTL identification (SNP×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_mRNA)
    - [eQTL identification (SNP×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_microRNA)
    - [eQTL identification (SNP×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_lncRNA)
    - [pQTL identification (SNP×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_Protein)
 
 - <b>Copy number variation (CNV)</b>
    - [CoCNV](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_CNV_Cor)
    <br>Optional models: Pearson; Spearman
    - [CoCNV (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_CNV_DiffCor)
    <br>Optional models: Pearson; Spearman
    - [mQTL identification (CNV×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_DNAm)
    - [eQTL identification (CNV×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_mRNA)
    - [eQTL identification (CNV×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_microRNA)
    - [eQTL identification (CNV×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_lncRNA)
    - [pQTL identification (CNV×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_Protein)
 
 - <b>DNA methylation (DNAm)</b>
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
 
 - <b>mRNA expression (mRNA)</b>
    - [eQTL identification (SNP×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_mRNA)
    - [eQTL identification (CNV×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_mRNA)
    - [eQTM identification (DNAm×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_mRNA)
    - [CoExpression (mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=mRNA_mRNA_Cor)
    <br>Optional models: Pearson; Spearman 
    - [CoExpression (mRNA, case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=mRNA_mRNA_DiffCor)
    <br>Optional models: Pearson; Spearman 
    - [Regulatory relationship identification (miRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_mRNA)
    - [Regulatory relationship identification (lncRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_mRNA)

 - <b>microRNA expression (miRNA)</b>
    - [eQTL identification (SNP×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_microRNA)
    - [eQTL identification (CNV×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_microRNA)
    - [eQTM identification (DNAm×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_microRNA)
    - [Regulatory relationship identification (miRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_mRNA)
    - [Regulatory relationship identification (miRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_mRNA)
    - [CoExpression (miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_microRNA_Cor)
    <br>Optional models: Pearson; Spearman 
    - [CoExpression (miRNA, case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=microRNA_microRNA_DiffCor)
    <br>Optional models: Pearson; Spearman

 - <b>long non-coding RNA expression (lncRNA)</b>
    - [eQTL identification (SNP×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_lncRNA)
    - [eQTL identification (CNV×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=CNV_lncRNA)
    - [eQTM identification (DNAm×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=DNAm_lncRNA)
    - [Regulatory relationship identification (lncRNA×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_mRNA)
    - [CoExpression (lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_lncRNA_Cor)
    <br>Optional models: Pearson; Spearman 
    - [CoExpression (lncRNA, case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=lncRNA_lncRNA_DiffCor)
    <br>Optional models: Pearson; Spearman 
 - <b>protein expression (protein)</b>
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

## Notice
WGIA’s online platform allows users to perform interaction analysis without the need for a dedicated GPU, as
it can run efficiently on standard hardware. However, considering that large data uploads may depend on user’s
internet speed, we also offer localized software [WGIA1.0](http://gpu.zjwm.cc/wgia/index.php/Index/software). If user’s choose to use our localized software, a
dedicated GPU was needed.

## Acknowledgements
Development of WGIA is a community effort. We would like to thank everybody who helped developing and testing.

