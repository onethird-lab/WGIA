![image](https://github.com/user-attachments/assets/d79d857d-c741-44f8-900c-0d3ec03272a9)# WGIA
WGIA: GPU-accelerated whole-genome interaction analyzing for everyone

## Introduction
<strong>WGIA is an open-access web application developed for genome-wide interaction analysis</strong>. WGIA leverages GPU parallel technologies to significantly enhance computational efficiency. Its framework facilitates high-speed pairwise interaction analysis, enabling extensive exploration of genome-wide interactions in the era of big data in molecular biology.<br>
<img src="/dblogo/index/2.png" style="max-width: 70%; display: inline-block;" data-target="animated-image.originalImage">
<strong>WGIA incorporates over 70 interaction processing functions</strong>, including correlation analysis within the same omics biomarkers (such as co-expression or differential co-expression for microarray and RNA-seq data, epigenetic interaction analysis, SNP-SNP interaction analysis) and the analysis of regulatory effects between different omics biomarkers (e.g., eQTLs, mQTLs, pQTLs).

## interaction analysis for each omics
- [Single nucleotide polymorphism (SNP)]
    - [LD](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_SNP_LD)
      optional models: Dprime; Rsquare
    - [SNP×SNP Interaction (case-control)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_SNP_Diff)
      Optional models: aa\*bb_vs_other; aa\*Bb_vs_other; aa\*BB_vs_other; Aa\*bb_vs_other; Aa\*Bb_vs_other; Aa\*BB_vs_other; AA\*bb_vs_other; AA\*Bb_vs_other; AA\*BB_vs_other; (AA+Aa)\*(BB+Bb)_vs_other; (AA+Aa)\*(BB)_vs_other; (AA)\*(BB+Bb)_vs_other; (AA)\*(BB)_vs_other; 
    - [mQTL identification (SNP×DNAm)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_DNAm)
    - [eQTL identification (SNP×mRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_mRNA)
    - [eQTL identification (SNP×miRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_microRNA)
    - [eQTL identification (SNP×lncRNA)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_lncRNA)
    - [pQTL identification (SNP×protien)](http://gpu.zjwm.cc/wgia/index.php/Index/job_center?AnalysisId=SNP_Protein)
- [Copy number variation (CNV)]
- [DNA methylation (DNAm)]
- [mRNA expression (mRNA)]
- [microRNA expression (miRNA)]
- [long non-coding RNA expression (lncRNA)]
- [protein expression (protein)]

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

