<?php

namespace App\Helper;


use App\Models\UserMNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class IHSGHelper
{
    public static function getEmitenList()
    {
        $emitenList = array(
            "BUKA","NICL","DEWI","BABP","MTDL","KRYA","NETV","SAGE","TRON","CBUT",
            "BBCA", "GOTO", "BBRI", "BMRI", "TLKM", "ANTM", "ASII", "CARE", "CASA", "ADMR", "ADRO", "UNTR", "NATO", "BBNI", "MDKA", "BEBS", "TCPI", "NICL", "BUMI", "BOGA", "SMGR", "BHAT", "ARTO", "ICBP", "BRPT", "MEDC", "INDF", "WINE", "TBIG", "KLBF", "MIDI", "BPTR", "INKP", "ITMG", "BIPI", "MIKA", "AKRA", "HRUM", "UNVR", "PGAS", "ACES", "CPIN", "BBTN", "SRTG", "BULL", "BANK", "INCO", "AMRT", "ENRG", "INDY", "ELIT", "BBKP", "CMNT", "ESTA", "OMED", "BBYB", "PTBA", "PBRX", "TPIA", "ESSA", "MPMX", "MTMH", "BRMS", "DEWI", "MNCN", "INTP", "INPS", "CBRE", "SCMA", "TKIM", "GULA", "BTPS", "ERAA", "ENAK", "BSBK", "AGII", "PNLF", "VTNY", "EMTK", "ISAT", "TINS", "TAYS", "BYAN", "EXCL", "RAJA", "TOWR", "WIFI", "HMSP", "BRIS", "KIOS", "DGIK", "MMIX", "HATM", "BEER", "MYOR", "DKFT", "ELSA", "DSNG", "FREN", "SHID", "CTRA", "WMUU", "SUNI", "WSKT", "AMAR", "BBRM", "BOSS", "JPFA", "AMIN", "PADA", "SLIS", "BELI", "MTEL", "MAPI", "RUIS", "PTPP", "SSMS", "DOID", "MKTR", "MSIN", "SIDO", "PWON", "NICL-W", "MLIA", "WIKA", "SMRA", "CHEM", "AGRO", "TOBA", "PRDA", "PTRO", "MLPL", "CMRY", "BELL", "AXIO", "BBSS", "SSIA", "WIRG", "CBPE", "LPPF", "KRYA", "JSMR", "RMKE", "BMTR", "GGRM", "NETV", "HEAL", "SMDR", "MGRO", "YELO", "SOUL", "UFOE", "MPPA", "ERTX", "BFIN", "EURO", "MTPS", "KIJA", "APIC", "IRRA", "PNBN", "STAA", "GOOD", "RALS", "WEHA", "HOMI", "LABA", "BHIT", "AALI", "TRJA", "IMPC", "ABMM", "ADHI", "PICO", "BSDE", "ZATA",
            "PSAB", "MAPA", "XKMS", "BSSR", "MMLP", "SKRN", "MEDS", "MARK", "BJTM", "RDTX", "SMCB", "TMAS", "BIRD", "IPPE", "TAPG", "AVIA", "AKSI", "JMAS", "BDMN", "DMAS", "ASLC", "SNLK", "MCOL", "PMMP", "MTSM", "INCF", "BNBR", "NZIA", "WMPP", "TRIS", "PANR", "CENT", "WAPO", "CARS", "IATA", "SMSM", "SFAN", "LSIP", "SDPC", "JAYA", "FREN-W2", "SINI", "PTIS", "WOOD", "BJBR", "CLEO", "DEWA", "CBUT", "FPNI", "BCIC", "KRYA-W", "SAME", "MARI", "BNGA", "BACA", "TSPC", "TOYS", "DRMA", "WINS", "HRTA", "SBMA", "PNIN", "ELPI", "GIAA", "MREI", "TRIN", "AUTO", "KEEN", "JKON", "OKAS", "TECH", "APLN", "KRAS", "HAIS", "LPKR", "CPRO", "GPSO", "PBID", "NINE", "ABBA", "GTBO", "BABP", "PNBS", "KPIG", "ELIT-W", "TUGU", "ASHA", "ASSA", "ARCI", "HEXA", "BMHS", "WTON", "RAFI", "TPMA", "BISI", "NISP", "BCAP", "ANJT", "FILM", "META", "BBHI", "MORA", "KJEN", "CRAB", "JAWA", "BNII", "BGTG", "ENZO", "ASPI", "BMBL", "RCCC", "JRPT", "PANI", "BKDP", "FITT", "GTSI", "MTDL", "KKGI", "BEST", "PSKT", "PGASDRCK3A",
            "BMAS", "KETR", "ULTJ", "GPRA", "KDTN", "MINA", "HDIT", "CBRE-W", "NFCX", "JARR", "COAL", "EAST", "ADES", "MBAP", "PKPK", "IPTV", "SRAJ", "FIMP", "APLI", "AYLS", "LINK", "TMPO", "APEX", "ISSP", "SMKL", "BSML", "INDX", "GDST", "MTWI", "GJTL", "WIIM", "SILO", "ARKO", "IMJS", "AGRS", "ARNA", "SMBR", "BINO", "TRGU", "ISAP", "DILD", "NELY", "MCAS", "AMOR", "MMIX-W", "POWR", "BVIC", "MERK", "IPCC", "ADMF", "GOLD", "GZCO", "KINO", "ADCP", "PCAR", "WEGE", "BMBL-W", "PDPP", "IDEA", "MRAT", "IMAS", "SOUL-W", "SMMT", "CAMP", "MLBI", "KIOS-W", "BCIP", "SIMP", "TRIM", "INDO", "SEMA", "SGER", "NOBU", "IPCM", "UANG", "VICI", "KUAS", "AHAP", "DMMX", "PALM", "CAKK", "SMDM", "INDR", "TLKMDRCM3A", "ASPI-W", "BWPT", "BAPA", "ESIP", "LEAD", "BUDI", "ALMI", "BBCADRCK3A", "SQMI", "SMKM", "SOCI", "SICO", "MKTR-W", "AISA", "BAJA", "IKAN", "FIRE", "ACST", "CFIN", "WIRG-W", "KKES", "CSRA", "VINS", "DNAR", "PRAY", "KAEF", "BNBA", "OASA", "DLTA", "TAXI", "ZYRX-W", "SATU", "ROTI", "CHEM-W", "PGUN", "TOTL", "NANO", "JAST", "OBMD", "MDKI", "PPRE", "TOPS", "ASRI", "HOKI", "CMPP", "R-LQ45X", "MDLN", "WGSH", "AMFG", "SWID", "DSFI", "NASI", "SDMU", "BINA", "GLVA", "SHIP", "MDKADRCM3A", "BSBK-W", "BRAM", "SMAR", "SGRO", "KOBX", "OILS", "PTDU", "COCO", "SAFE", "TRUK", "SWID-W", "BTPN", "PDES", "ASGR", "GEMS", "ISAP-W", "MAIN", "CSAP", "FAPA", "RAFI-W", "LUCY", "ZONE", "MPOW", "ARII", "AKPI", "FMII", "SULI", "APII", "LION", "DGNS", "PSSI", "MBSS", "IFSH", "CLPI", "MAPB", "PANS", "RICY", "GHON", "POLA", "TBLA", "KDTN-W", "ITMA", "LTLS", "RODA", "TNCA", "ASMI", "DUTI", "OLIV", "AMAN", "ESTA-W", "CCSI", "RIGS", "DYAN", "PEHA", "TLDN", "BBSI", "EPMT", "BIMA", "HRME", "ZYRX", "DNET", "OPMS", "BMSR", "POLL", "VRNA", "PURI", "MCOR", "WOMF",
            "BSIM", "BMRIDRCK3A", "JAYA-W", "BRPTDRCM3A", "INPC", "PGLI", "UCID", "MAYA", "URBN", "RUNS", "PSDN", "AMMS-W", "BUAH", "HITS", "GGRP", "TEBE", "ATAP", "LMPI", "BIKE", "JTPE", "ITIC", "UVCR", "DPNS", "PTPW", "EKAD", "KARW", "IBOS", "ZBRA", "ESTI", "BOLA", "GMFI", "ALDO", "SPMA", "MASB", "DVLA", "AMMS", "MEGA", "NIKL", "NRCA", "TOOL", "PAMG", "UNIQ", "BKSW", "UVCR-W", "BLTZ", "FORU", "SCNP", "DFAM", "UNVRDRCM3A", "MITI", "BATA", "MFIN", "SOTS-W", "PPGL", "LUCK", "BEEF", "IDPR", "BINO-W", "PGJO", "TOTO", "PZZA", "CEKA", "PTSN", "KBLI", "INOV", "CITA", "BALI", "UNIC", "INAF", "SDRA", "DIVA", "SAMF", "INCI", "BPFI", "RSGK", "UNSP", "LPPS", "PEGE", "HOPE-W", "IBOS-W", "MFMI", "ZINC", "INTD", "TRUE-W", "MYOH", "PBSA", "WOWS", "ANTMDRCK3A", "SOSS", "ALKA", "AIMS", "RANC", "BBRIDRCM3A", "WIFI-W", "SRSN", "DCII", "TELE", "KLIN", "POLI", "CASH", "OLIV-W", "BESS", "CSIS", "HRUMDRCM3A", "BAUT-W", "TAMA-W", "HOPE", "PURA-W", "JIHD", "DEPO", "BIKE-W", "SCCO", "TCID", "BOBA", "ADMG", "ASJT", "DIGI", "KEJU", "AMAG", "TOOL-W", "SICO-W", "NANO-W", "EURO-W", "FOOD", "MICE", "MOLI", "BKSL", "KBLM", "MSKY", "SPTO", "WINR-W", "ASBI", "ALTO", "KBLV", "INPP", "BESS-W", "NICK", "DADA-W", "ADRODRCM3A", "MBTO", "POLU", "KOIN", "BLUE", "XIPI", "BNLI", "HDFA", "ESIP-W", "GWSA", "XAQA", "NTBK-W", "MGLV", "LPCK", "GSMF", "XISR",
            "IGAR", "POLY", "TIRT", "FUJI", "LABA-W", "PORT", "LPGI", "PPRO", "KDSI", "XIHD", "OMRE", "KBAG-W", "ATIC", "JAST-W", "RISE", "BTON", "GEMA", "PMJS", "SOTS", "IPOL", "CMNP", "KMDS", "TRUE", "ENZO-W", "PJAA", "YPAS", "ETWA", "ASDM", "HERO", "FISH", "YULE", "IPAC", "PYFA", "TBMS", "KMTR", "MTLA", "TFAS", "MDIA", "SBAT-W", "PLAN", "VICO", "ICON", "STTP", "PRAS", "INCODRCM3A", "XKIV", "MLPT", "PRIM", "LPIN", "TAMA-W2", "TRST", "POLA-W", "NTBK", "BBLD", "XBIN", "XPCR", "KICI", "XBSK", "SOSS-W", "CANI", "INDO-W", "FAST", "XCLQ", "INDS", "PSGO", "XPDV", "PUDP", "SAPX", "IKBI", "CLAY", "KLIN-W", "BEKS", "CASS", "MPRO", "AGAR", "CTBN", "DAYA", "XNVE", "BVIC-W", "SIPD", "XIIT", "LCKM", "WINR", "LMSH", "VOKS", "ALDO-W", "RBMS", "SMMA", "LRNA", "BUKK", "PLAN-W", "MYTX", "XBID", "SOHO", "LAND", "XSSI", "CNTX", "IFII", "BABP-W3", "XSSK", "PURA", "XIJI", "BIPP", "TGKA", "SOFA", "PTSP", "TALF", "LUCY-W", "XCIS", "TRUS", "TGRA", "XPES", "ICBPDRCM3A", "ARTA", "SONA", "XPSG", "BAUT", "CNKO", "XSBC", "XAFA", "ROCK", "XBES", "NIRO", "BOLT", "BLTA", "RELI", "INRU", "XIIF", "DMND", "PLIN", "KOPI", "NASA", "WICO", "BAPI", "SURE", "ASRM", "KREN", "ECII", "ARKA", "KBAG", "DART", "GDYR", "BIKA", "XIFE", "EMDE", "XDSG", "XIIC", "ANDI", "TIFA", "CMNP-W", "XSMU", "HKMU", "CTTH", "NPGF", "STAR", "DWGL", "XIID", "MIRA", "KOTA", "SKBM", "CBMF", "AKKU",
            'AKKU', 'XIML', 'VIVA', 'SWAT', 'XILV', 'HELI', 'TRIN-W2', 'CINT', 'REAL', 'CPRI', 'TAMA', 'DEAL', 'BTEK', 'TARA', 'TAMU', 'SBAT', 'PADI', 'MTFN', 'KAYU', 'JGLE', 'IKAI', 'ELTY'
        );

        return json_encode( array_values(array_unique($emitenList)));
    }


}


